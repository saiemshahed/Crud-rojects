<?php
define('DB_NAME','/xampp/htdocs/crud/data/db.txt');

function seed() {
$data =      array(
          array(
            'id'    => 1,
            'fname' => 'Kamal',
            'lname' => 'Ahmed',
            'roll'  => '11'
            ),
        array(
        'id'    => 2,
        'fname' => 'Jamal',
        'lname' => 'Ahmed',
        'roll'  => '12'
        ),
        array(
        'id'    => 3,
        'fname' => 'Ripon',
        'lname' => 'Ahmed',
        'roll'  => '9'
        ),
        array(
        'id'    => 4,
        'fname' => 'Nikhil',
        'lname' => 'Chandra',
        'roll'  => '8'
        ),
        array(
        'id'    => 5,
        'fname' => 'John',
        'lname' => 'Rozario',
        'roll'  => '7'
        )
        );
$serializedData = serialize( $data );
file_put_contents( DB_NAME, $serializedData, LOCK_EX );
}

function generateReport(){
    $serializedData=file_get_contents(DB_NAME);
    $students=unserialize($serializedData);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th style="align-content: baseline">Actons</th>
        </tr>
        <?php
        foreach ($students as $student){
            ?>
            <tr>
                <td><?php printf('%s %s',$student['fname'],$student['lname']); ?></td>
                <td><?php printf('%s',$student['roll']); ?></td>
                <td><?php printf('<a href="/crud/index.php? task=edit & id=%s">Edit</a> | <a class="delete" href="/crud/index.php? task=delete & id=%s">Delete</a>',$student['id'],$student['id']); ?></td>
            </tr>
            <?php
        }
        ?>

    </table>

<?php
}
function addstudent($fname,$lname,$roll)
{
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student) {
        if ($student['roll'] == $roll) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $newid = getNewId($students);
        $student = array(
            'id' => $newid,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );
        array_push($students, $student);
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}
function getStudent($id){
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student) {
        if ($student['id'] == $id) {
//            $found = true;
//            break;
            return $student;
        }
        return false;
    }
}

function updateStudent($id,$fname,$lname,$roll){
    $serializedData = file_get_contents(DB_NAME);
    $students=unserialize($serializedData,LOCK_EX);
    $found=false;
    foreach ($students as $student) {
        if ($student['roll'] == $roll && $student['id']!=$id) {
//            $found = true;
//            break;
            return student;
        }
    }
    if(!$found) {
        $students = unserialize($serializedData);
        $students[$id - 1]['fname'] = $fname;
        $students[$id - 1]['lname'] = $lname;
        $students[$id - 1]['roll'] = $roll;
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}

function deleteStudents($id){
    $serializedData = file_get_contents(DB_NAME);
    $students=unserialize($serializedData,LOCK_EX);
     $i=0;
    foreach ($students as $student) {
        if ($student['id'] == $id) {
            unset($student[$i]);
        }
        $i++;
    }


    $serializedData = serialize( $students );
    file_put_contents( DB_NAME, $serializedData, LOCK_EX );

}
function getNewId($students){
    $maxId=max(array_column($students,'id'));
    return $maxId+1;
}

