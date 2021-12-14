<?php
/**
 * Файл класса контроллера главной
 *
 * @package app
 * @author  Ruslan Heorhiiev
 * @version 1.0.0
 */
 
namespace App\Controllers;

use App\Entities\UserEntity;
use App\Services\ResponseService;
use App\Services\ArchiveService;
use App\Services\RequestService;
use App\Services\AuthorizationService;


class HomeController extends Controller {
    
    public function main() {

        $user = AuthorizationService::getAuthUser();

        if ($user) {            
            // кнопка "сохранить все записи"
            if (RequestService::post('save_all_posts')) {
                ArchiveService::addPosts(
                    RequestService::post('posts'),
                    $user
                );

                return;
            }
    
            return $this->view('pages/home', [
                'user' => $user,
                'roles' => UserEntity::getRoles(),
                'posts' => ArchiveService::getPosts(),
            ]);
        }

        // редирект если не авторизирован
        ResponseService::redirect('/entrance.php');
    }
}