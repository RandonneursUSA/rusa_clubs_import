<?php

namespace Drupal\rusa_clubs_import\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;  
use Drupal\node\Entity\Node;
use Drupal\rusa_api\RusaClubs;
use Drupal\rusa_clubs_import\RusaStatesBuild;

class RusaClubsImportForm extends FormBase {

    // Required function
    public function getFormId() {
        return 'rusa_clubs_import_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['clubs'] = [
            '#type'   => 'item',
            '#markup' => $this->t("Click the Import button to begin the transfer of Club data into Drupal"),
        ];


        $form['choice'] = [
            '#type'    => 'radios',
            '#options' => [
                'states' => $this->t('Build States'),
                'clubs'  => $this->t('Import Clubs'),
            ]
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Import'),
        ];

        $form['#attributes']['class'][] = 'rusa-form';
        $form['#attached']['library'][] = 'rusa_api/rusa_style';

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

        if ($form_state->getValue('choice') == 'states') {
        
            // Build the states vocabulary. This is pretty quick so no need to batch
            $this->buildStates();
        }
        else {
        
            // Get the clubs from GDBM
            $clobj  = new RusaClubs();
            $clubs  = $clobj->getClubsArray();
    
            // Setup batch process
            $batch = [
                'title' => $this->t('Importing clubs'),
                'operations' => [['Drupal\rusa_clubs_import\Form\RusaClubsImportForm::batchStart', ['clubs']]],
                'finished'   => 'Drupal\rusa_clubs_import\Foem\RusaClubsImportForm::batchFinished',
            ];

            foreach ($clubs as $club) {
                $batch['operations'][] =  ['Drupal\rusa_clubs_import\Form\RusaClubsImportForm::batchProcess', [$club]];
            }

            batch_set($batch);
        }
	}

	public static function batchStart($clubs, &$context) {
        $context['results']['updates'] = 0;
        $context['results']['additions'] = 0;
  }


	public static function batchprocess($club, &$context) {
		if ($club->name === "Randonneurs USA" ||		
            $club->name === "International Randonneurs"  ||
            $club->name === "Independent"  ||
            $club->acpcode < 900000 ) {
        
            $context['message'] = t("Skipping " . $club->name);
            return;
		}
    
        // Check to see if club exists
        $result = \Drupal::entityQuery('node')
            ->condition('type', 'club')
            ->condition('field_club_acpcode', $club->acpcode, '=' )
            ->execute();
        if (!empty($result)) { 
            $nid = array_shift($result); 
            $node_storage = \Drupal::entityTypeManager()->getStorage('node');
            $node = $node_storage->load($nid);
	        $context['message'] = t("Updating club " . $club->name);
            $context['results']['updates']++ ;
        }
        else {
    	    $node = Node::create(['type' => 'club']);
    	    $node->set('title', $club->name);
            $node->enforceIsNew();
            $node->save();
      
	        $context['message'] = t("Adding club " . $club->name);
            $context['results']['additions']++ ;
        }

        // Now set other values
        // Note: we do this for bot new nodes and updates
        $node->set('field_club_acpcode', $club->acpcode);
        $node->set('field_club_status', $club->status == 'A' ? TRUE : FALSE);
        $node->set('field_club_date_added', preg_replace("/\//",  "-", $club->date));
        $node->set('body', [
            'value'  => $club->notes,
            'format' => 'basic_html',
          ]);
	
        // Set the State taxonomy reference
		preg_match("/9(\d\d)/", $club->acpcode, $matches);
		if (isset($matches[1])) {
     	    $state_code = $matches[1];
            $entity_id = \Drupal\rusa_clubs_import\Form\RusaClubsImportForm::getState($state_code);
            if (!empty($entity_id)) { 
				$node->set('field_club_state', $entity_id);
			}
		}

        $node->save();
    		
    }

	public static function batchFinished($success, $results, $operations) {
        $messenger = \Drupal::service('messenger');

        if ($success) {
            $messenger->addMessage(t('@count clubs added.', [ '@count' => $results['additions'] ]));
		    $messenger->addMessage(t('@count clubs updated.', [ '@count' => $results['updates'] ]));
	    }
        else {
            $error_operation = reset($operations);
            $messenger->addMessage(t('An error occurred while processing @operation with arguments : @args', [
                '@operation' => $error_operation[0],
                '@args' => print_r($error_operation[0]),
            ]));
        }
    }


    public static function getState($code) {
    	$result = \Drupal::entityQuery('taxonomy_term')
      	    ->condition('vid', 'states')
      	    ->condition('field_state_code', $code, "=")
      	    ->execute();
    	if (!empty($result)) {
      	    return  array_shift($result);
		}
    }

    protected function buildStates() {
        $states = RusaStatesBuild::getStates();
  
        foreach ($states as $st => $state) {
          $term = Term::create(array(
            'parent'                    => array(),
            'name'                      => $state['name'],
            'vid'                       => 'states',
            'field_state_abbreviation'  => $st,
            'field_state_code'          => $state['code'],
            ));
          $term->save();
        }
    }


  
}


