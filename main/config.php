<?php

require '../vendor/autoload.php';
/**
*use Kreait\Firebase\Factory;
*use Kreait\Firebase\ServiceAccount;
*use Google\Cloud\Firestore\FirestoreClient;
**/
//export GOOGLE_APPLICATION_CREDENTIALS="path/to/your/keyfile.json";
//namespace Google\Cloud\Samples\Firestore;

use Google\Cloud\Firestore\FirestoreClient;

/**
 * Initialize Cloud Firestore with default project ID.
 * ```
 * initialize();
 * ```
 */
function initialize()
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient();
    printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);
}
//namespace Google\Cloud\Samples\Firestore;

//use Google\Cloud\Firestore\FirestoreClient;

/**
 * Add data to a document.
 * ```
 * ref https://firebase.google.com/docs/firestore/manage-data/add-data
 * add_data('your-project-id');
 * ```
 **/
//
// s2rHAqEzmdq5zml2LKoB
$projId = 'aikinow-web';
add_data($projId);  // { @working }
//get_all($projId); // { @working }
//delete($projId,);  // { @working }
//run_simple_transaction($projId); { @not working }
function add_data($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_add_data_1]
    $rand = rand();
    $docRef = $db->collection('users')->document($rand);
    $docRef->set([
        'category'    => "Mecyhanical Engineer",
        'email'       => "mechy@gmail.com",
        'fname'       => "Amiynu",
        'lname'       => "M. yBulangu",
        'password'    => "123456",
        'phone'       => "08012345678",
        'username'    => "blgy"
    ]);
    printf('Added data to the document ('.$rand.') in the (Artissan) collection.' . PHP_EOL);
}

/**
 * Retrieve all documents from a collection.
 * ```
 * get_all('your-project-id');
 * ```
 */
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

/**
 * Delete all collection from a documents.
 * ```
 * we needs [ a ProjectId, Collection(table), document(Id)];
 * ```
 */
function delete($projectId){
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_batch_write]
    $batch = $db->batch();

    $laRef = $db->collection('users')->document('1452154430');
    $batch->delete($laRef);

    # Commit the batch
    $batch->commit();
    echo 'deleted';

}


/**
 * Run a simple transaction.
 * ```
 * // ref = https://firebase.google.com/docs/firestore/manage-data/transactions
 * run_simple_transaction('your-project-id');
 * ```
 *
**/
function run_simple_transaction($projectId)
{
    # Update the population for 4e3dd94aded04cd9245d8ac620cf8f06
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);

    $sfRef = $db->collection('Artissan')->document('4e3dd94aded04cd9245d8ac620cf8f06');
    $batch->update($sfRef, [
        ['fname' => 'Auwal', 'email' => 'b@g.com']
    ]);
    # [END fs_run_simple_transaction]
    printf('Ran a simple transaction to update the population field in the SF document in the cities collection.' . PHP_EOL);
}
/** 
function run_simple_transaction($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START fs_run_simple_transaction]
    //  4e3dd94aded04cd9245d8ac620cf8f06
    $cityRef = $db->collection('Artissan')->document('4e3dd94aded04cd9245d8ac620cf8f06');
    $db->runTransaction(function (Transaction $transaction) use ($cityRef) {
        $snapshot = $transaction->snapshot($cityRef);
        $newPopulation = $snapshot['population'] + 1;
        $transaction->update($cityRef, [
            ['path' => 'population', 'fname' => $newPopulation]
        ]);
    });
    # [END fs_run_simple_transaction]
    printf('Ran a simple transaction to update the population field in the SF document in the cities collection.' . PHP_EOL);
}
**/

// end edit


/**
 * Batch write.
 * ```
 * // ref = https://firebase.google.com/docs/firestore/manage-data/transactions
 * batch_write('your-project-id');
 * ```
 */
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
        ['path' => 'population', 'j ' => 1000000]
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

/**
 * Delete a collection.
 * ```
 * delete_collection($collectionReference, $batchSize);
 * ```
 */

# [START fs_delete_collection]
// Alot of research ..  delete_collection($collectionReference, $batchSize 
# Delete LA
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



/**
 * Delete a document.
 * ```
 * delete_doc('your-project-id');
 * ```
 */
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
// <end class=""></end>
/**
$usersRef = $db->collection('users');
$snapshot = $usersRef->documents();
foreach ($snapshot as $user) {
    printf('User: %s' . PHP_EOL, $user->id());
    printf('First: %s' . PHP_EOL, $user['first']);
    if (!empty($user['middle'])) {
        printf('Middle: %s' . PHP_EOL, $user['middle']);
    }
    printf('Last: %s' . PHP_EOL, $user['last']);
    printf('Born: %d' . PHP_EOL, $user['born']);
    printf(PHP_EOL);
}
printf('Retrieved and printed out all documents from the users collection.' . PHP_EOL);
  **/
?>