<?php
require '../vendor/autoload.php';
require 'db.php';
//
/**
*use Kreait\Firebase\Factory;
*use Kreait\Firebase\ServiceAccount;
*use Google\Cloud\Firestore\FirestoreClient;
**/
//export GOOGLE_APPLICATION_CREDENTIALS="path/to/your/keyfile.json";
//namespace Google\Cloud\Samples\Firestore;

//class engine extends Google\Cloud\Firestore\FirestoreClient
class engine extends db
{
    use Google\Cloud\Firestore\FirestoreClient;
    protected $db = 'aikinow-web';
    public function db()
    {
        // Create the Cloud Firestore client
        $db = new FirestoreClient([
            'projectId' => $this->db,
        ]);
    }

    public function passHash($p)
    {
        $en = md5($p);
        password_hash($en);
        return true;
    }

    public function passVer($p)
    {
        $en = md5($p);
        $ver = password_verify($en, $db);
        if(!$ver) {
            return false;
        }else{
            return true;
        }
    }
 
    public function create($table, $cat, $email, $fname, $lname, $pass, $phone, $username)
    {
       $rand = rand();
       $docRef = db()->collection($table)->document($rand);
        if (!$docRef) {
            return false;
        }else{
            $docRef->set([
                'category'    => $cat,
                'email'       => $email,
                'fname'       => $fname,
                'lname'       => $lname,
                'password'    => $pass,
                'phone'       => $phone,
                'username'    => $username
            ]);
            return true;
        }
    }

    public function view($table)
    {
       $usersRef = db()->collection($table);
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

    public function update($table, $id)
    {
        # Update the population for SF
        $batch = db()->batch();
        $sfRef = db()->collection($table)->document($id);
        if (!$sfRef) {
            return false;
        }else{
            $batch->update($sfRef, [
                ['path' => 'population', 'j ' => 1000000]
            ]);
            $batch->commit();
            return true;
        }
    }

    public function update1($projectId)
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

    public function delete($table, $id)
    {
       $batch = db()->batch();
       $laRef = db()->collection($table)->document($id);
       if (!$laRef) {
           return false;
       }else{
        $batch->delete($laRef);
        $batch->commit();
        return true;
       }
    }  
    
    # [START fs_delete_collection]
    // Alot of research ..  delete_collection($collectionReference, $batchSize 
    # Delete LA
    public function delete_collection($collectionReference, $batchSize)
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
   
}
?>