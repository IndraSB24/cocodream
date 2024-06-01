<?php

    function sess_activeUserId(){
        return session('active_user_id');
    }

    function sess_activeUsername(){
        return session('active_username');
    }

    function sess_activeEntitasId(){
        return session('active_entitas_id');
    }

    function sess_isLogin(){
        return session('is_login');
    }
    
    