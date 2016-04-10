<?php

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $social_links = $this->model->select('social_links', '*');

        $this->data['social_links'] = $social_links;
    }

    public function enter() {
        try {
        
            $target = null;

            $target = $this->uri->segment(2);

            if ($target == null) {

                $blogs = $this->model->select('admin_post', '*', array('LOWER(title)' => 'blog'));

                if (isset($blogs)) {

                    $this->data['blogs'] = $blogs;
                } else {

                    $this->data['msg'] = 'There is no any blog!';
                }

                
                foreach ($blogs as $k=>$all_blog) {
                    
                    $blog_comments = $this->model->select('blog_comments', '*', array('blog_id' => $all_blog['sno']),array('date_added'=>'desc'));
 
                    $date = $all_blog['date_added'];

                    $year = date('Y', strtotime($date));
                    //echo $year;

                    /* if (!array_key_exists($year, $sorted)) {

                      $sorted[$year] = array();
                      } */

                    $month = date('F', strtotime($date));

                    /* if (!array_key_exists($month, $sorted)) {

                      $sorted[$year][$month] = array();
                      } */
                    $sorted[$year][$month][] = $all_blog;

                    //$sorted[$year][$month]['count'] = count($sorted[$year][$month]);
                    //echo'<pre>'; print_r($blog_comments);
                    if(isset($blog_comments) && is_array($blog_comments))
                    $this->data['comment_count'][$k] = count($blog_comments);
                }
                
               
                
                
                $this->data['blog_archive'] = $sorted;



                $this->page = 'blog/blog';

                $this->header = 200;

                $this->message = '';

                $this->root = 'home/home';

                $this->response();
            } else {

                $id = $this->uri->segment(3);

                $this->blog_detail($id);
            }
        } catch (Exception $e) {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    public function blog_detail($id) {

        $data = $this->input->post(NULL, TRUE);
        
        $user = $this->model->select('business_members', 'sno,person_name', array('username' => $this->session->userdata('username')), NULL, 1);
        
        if(!empty($data) && $this->session->userdata('login_type') != false){
            
            $comment = $data['comment'];
                   
           $added_comment = $this->model->insert('blog_comments', array('u_id'=>$user->sno, 'blog_id'=>$id, 'comment'=>$comment));
           
           if($added_comment)
               
               $this->data['msg'] = "Your comment has been added!";
        } 


        $blogs = $this->model->select('admin_post', '*', array('LOWER(title)' => 'blog', 'sno' => $id), null, 1);

        if (isset($blogs)) {

            $this->data['blogs'] = $blogs;
        } else {

            $this->data['msg'] = 'There is no any blog!';
        }

        $blog_comments = $this->model->select('blog_comments', '*', array('blog_id' => $id), array('date_added'=>'desc'));

        if(isset($blog_comments) && is_array($blog_comments))
        $this->data['comment_count'] = count($blog_comments);
        
        $sorted = array();

        if (isset($blog_comments) && is_array($blog_comments)) {

            foreach ($blog_comments as $k => $comment) {

                $blogger = $this->model->select('business_members', 'username', array('sno' => $comment['u_id']), null, 1);

                $blog_comments[$k]['blogger'] = $blogger->username;
            }

            //$this->data['comments'][$k]['blogger'] = $blogger;
            $this->data['comments'] = $blog_comments;
        }

        $all_blogs = $this->model->select('admin_post', '*', array('LOWER(title)' => 'blog'));

        //echo '<pre>'; print_r($all_blogs);

        foreach ($all_blogs as $all_blog) {

            $date = $all_blog['date_added'];

            $year = date('Y', strtotime($date));
            //echo $year;

            /* if (!array_key_exists($year, $sorted)) {

              $sorted[$year] = array();
              } */

            $month = date('F', strtotime($date));

            /* if (!array_key_exists($month, $sorted)) {

              $sorted[$year][$month] = array();
              } */
            $sorted[$year][$month][] = $all_blog;

            //$sorted[$year][$month]['count'] = count($sorted[$year][$month]);
        }

        $this->data['blog_archive'] = $sorted;


        $this->page = 'blog/blog_detail';

        $this->header = 200;

        $this->message = '';

        $this->root = 'home/home';

        $this->response();
    }

}
