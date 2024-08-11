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

    function sess_activeRole(){
        return session('active_role');
    }

    function sess_isLogin(){
        return session('is_login');
    }

    function sess($kode) {
        return session()->get($kode);
    }

    function all_sess() {
        return session()->get();
    }

    function check_session()
    {
        if (session()->get('is_login') === null) {
            return redirect()->to('/auth/logout')->send();
            exit;
            
        } else {
            $lastActivity = session()->get('last_activity');
            if ($lastActivity && ((time() - $lastActivity) > (2 * 3600))) {
                session()->destroy();
                return redirect()->to('/auth/logout');
                exit;
            }
        }
    }
    
    