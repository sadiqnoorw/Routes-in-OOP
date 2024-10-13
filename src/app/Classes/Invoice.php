<?php
namespace App\Classes;

class Invoice
{
    public  function index()
    {
        echo 'Invoice';
    }

    public function create()
    {
        echo '<form action="" method="post"><input type="input" name="amount"></form>';
    }

    public function store()
    {
        var_dump($_POST);
    }
}

