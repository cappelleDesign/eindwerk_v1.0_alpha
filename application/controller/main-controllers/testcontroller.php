<?php

/*
 * FOR TESTING PURPOSES ONLY 
 * 
 */

/**
 * Description of testcontroller
 *
 * @author jens
 */
class TestController extends SuperController {

    public function index() {
        $_POST['data'] = 'testing';
        $this->direct('test.php');
    }

    public function userDistDbTest() {
        require 'testing/db/user_dist_db_tests.php';
    }
    
    public function userDbTest() {
        require 'testing/db/user_db_tests.php';
    }
    
    public function commentDbTests() {
        require 'testing/db/commentTestingDB.php';
    }

    public function commentServiceTests() {
        require 'testing/service/commentTestingService.php';
    }

    public function dateTests() {
        require 'testing/model/timeTesting.php';
    }

    public function gameDistDbTest() {
        require 'testing/db/game_dist_db_tests.php';
    }

    public function gameDbTest() {
        require 'testing/db/game_db_tests.php';
    }

    public function reviewDistDbTest() {
        require 'testing/db/rev_dist_db_test.php';
    }
    
    public function reviewDbTest() {
        require 'testing/db/rev_db_test.php';
    }
}
