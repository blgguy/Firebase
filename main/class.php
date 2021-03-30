<?php

require '../vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

/**
 * firebase class
 */
function get_all($projectId)
    {
        
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);

    // # [START fs_get_all]
    $usersRef = $db->collection('Artissan');
    //$snapshot = $usersRef->documents();
    
    $Data = array();
    while ( $snapshot = $usersRef->documents() ){
        $Data[] = $snapshot;
    }
    return $Data;

    }

/**

function initialize()
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient();
    printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);
}

// s2rHAqEzmdq5zml2LKoB
//$projId = 'aikinow-web';
//add_data($projId);
get_all($projId);
//run_simple_transaction($projId);
function add_data($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_add_data_1]
    $rand = md5('awakiidhdhd');
    $docRef = $db->collection('Artissan')->document($rand);
    $docRef->set([
        'category'    =>"Electrician",
        'email'       => "bulangu97@gmail.com",
        'fname'       => "Aminu",
        'lname'       => "Bulangu",
        'password'    => "123456",
        'phone'       => "080995757679",
        'username'    => "bulanguu"
    ]);
    printf('Added data to the document ('.$rand.') in the (Artissan) collection.' . PHP_EOL);
}


// * Retrieve all documents from a collection.
// * ```
// * get_all('your-project-id');

function get_all($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_get_all]
    $usersRef = $db->collection('Artissan');
    $snapshot = $usersRef->documents();
    foreach ($snapshot as $user) {
        printf('User: %s' . PHP_EOL, $user->id());
        printf('First Name: %s' . PHP_EOL, $user['fname']);
        if (!empty($user['lname'])) {
            printf('Last Name: %s' . PHP_EOL, $user['lname']);
        }
        //printf('Last: %s' . PHP_EOL, $user['last']);
        printf('Username: %s' . PHP_EOL, $user['username']);
        printf('<br>');
        printf(PHP_EOL);
    }
    printf('Retrieved and printed out all documents from the Artissan collection.' . PHP_EOL);
    # [END fs_get_all]
}

function batch_write($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_batch_write]
    $batch = $db->batch();

    # Set the data for NYC
    $nycRef = $db->collection('cities')->document('NYC');
    $batch->set($nycRef, [
        'name' => 'New York City'
    ]);

    # Update the population for SF
    $sfRef = $db->collection('cities')->document('SF');
    $batch->update($sfRef, [
        ['path' => 'population', 'value' => 1000000]
    ]);

    # Delete LA
    $laRef = $db->collection('cities')->document('LA');
    $batch->delete($laRef);

    # Commit the batch
    $batch->commit();
    # [END fs_batch_write]
    printf('Batch write successfully completed.' . PHP_EOL);
}

// end batch edit

# [START fs_delete_collection]
// Alot of research ..  delete_collection($collectionReference, $batchSize 
function delete_collection($collectionReference, $batchSize)
{
    $documents = $collectionReference->limit($batchSize)->documents();
    while (!$documents->isEmpty()) {
        foreach ($documents as $document) {
            printf('Deleting document %s' . PHP_EOL, $document->id());
            $document->reference()->delete();
        }
        $documents = $collectionReference->limit($batchSize)->documents();
    }
}
# [END fs_delete_collection]


// * Delete a document.
 
function delete_doc($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_delete_doc]
    $db->collection('cities')->document('DC')->delete();
    # [END fs_delete_doc]
    printf('Deleted the DC document in the cities collection.' . PHP_EOL);
}
**/
?>