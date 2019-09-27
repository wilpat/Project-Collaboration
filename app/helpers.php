<?php

function gravatar_url($email){
    $email = md5($email);
    return "https://s.gravatar.com/avatar/{{ md5($email) }}?s=60"
}