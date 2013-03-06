<?php
class User extends AppModel
{
    public $belongsTo = 'Twitter';

    public $validator = array(
        'mail' => 'required',
    );
}
