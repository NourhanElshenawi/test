<?php
namespace Nourhan\Controllers;






use Nourhan\Database\DB;
use Nourhan\Services\Upload;
use Nourhan\ReCaptcha;
use Nourhan\Services\ChangeCarousel;

class MainController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo $this->twig->render('index.twig');
    }

    public function calendar()
    {
        echo $this->twig->render('calendar.twig');
    }

    public function fitnessProgram()
    {
        echo $this->twig->render('fitnessProgram.twig');
    }

    public function home()
    {
        $DB = new DB();
        $carouselImages = $DB->getCarousel();

        echo $this->twig->render('home.twig', array('carouselImages'=> $carouselImages));
    }

    public function admin()
    {
        $DB = new DB();
        $carouselImages = $DB->getCarousel();
        $allCarouselImages = $DB->getAllCarousel();
        echo $this->twig->render('admin.twig', array('carouselImages'=> $carouselImages, 'allCarouselImages'=> $allCarouselImages));
    }

    public function login()
    {
        echo $this->twig->render('login.twig');
    }

    public function adminLogin()
    {
// your secret key
        $secret = "6Lel3ggUAAAAACT3Xz7dfhUhvFGALwDrXgtwFeON";
// empty response
        $response = null;
// check secret key
        $reCaptcha = new ReCaptcha\ReCaptcha($secret);

// if submitted check response
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }

        if ($response != null && $response->success) {
            //REDIRECT TO PROFILE
            echo "Hi " . $_POST["username"] . " (" . $_POST["password"] . "), thanks for submitting the form!";
        } else {
            //REDIRECT TO ERROR'
            echo "not submitted";
        }
    }

    public function profile()
    {
        echo $this->twig->render('customer/profile.twig');
    }
    public function car()
    {
        var_dump($_POST);


        $DB = new DB();
        $carouselImages = $DB->getCarousel();
        $notIncludedCarouselImages = $DB->getNotIncludedCarousel();
        echo $this->twig->render('carousel.twig', array('carouselImages'=> $carouselImages, 'notIncludedCarouselImages'=> $notIncludedCarouselImages));
    }

     //////////////////////
    public function includeInCarousel()
    {
        echo "HIIII";
//        $arr = $_POST['inc'];
        $incl = $_GET['key1'];
        echo ".........";
//        var_dump($_GET);
        $position = $_GET['position'];
        echo "ID: ".$incl;
        echo "POSITION".$position;
//        echo "ID: "+$incl;
//        echo "POSITION: "+$position;
        $DB = new DB();
            $DB->includeInCarousel($incl, $position);

        $carouselImages = $DB->getCarousel();
        $notIncludedCarouselImages = $DB->getNotIncludedCarousel();
        echo $this->twig->render('admin2.twig', array('carouselImages'=> $carouselImages, 'notIncludedCarouselImages'=> $notIncludedCarouselImages));
    }
   /////////////////////////////


    //////////////////////
    public function removeFromCarousel()
    {
        echo "RIIII";
        $notIncl = $_GET['key1'];

        echo ".........";
//        echo "ID: ".$notIncl;
//        echo "POSITION: "+$position;
        $DB = new DB();
        $DB->removeFromCarousel($notIncl);

        $carouselImages = $DB->getCarousel();
        $notIncludedCarouselImages = $DB->getNotIncludedCarousel();
        echo $this->twig->render('admin2.twig', array('carouselImages'=> $carouselImages, 'notIncludedCarouselImages'=> $notIncludedCarouselImages));
    }
    /////////////////////////////


    public function deleteFromCarousel()
    {
        echo "DIIII";
        $del = $_GET['key1'];

        echo ".........";
//        echo "ID: ".$notIncl;
//        echo "POSITION: "+$position;
        $DB = new DB();
        $DB->deleteCarouselImage($del);

        $carouselImages = $DB->getCarousel();
        $notIncludedCarouselImages = $DB->getNotIncludedCarousel();
        echo $this->twig->render('admin2.twig', array('carouselImages'=> $carouselImages, 'notIncludedCarouselImages'=> $notIncludedCarouselImages));
    }
    /////////////////////////////

    public function upload()
    {
        if(isset($_POST['submit'])){
            $upload = new Upload();
        }  else {
            if($_POST['included'] == "Included"){
                $included = 1;
            } else $included = 0;
            $DB = new DB();
            $DB->updateCarousel($_POST['id'], $_POST['position'], $included) ;
        }

        $carouselImages = $DB->getCarousel();
        $allCarouselImages = $DB->getAllCarousel();
        echo $this->twig->render('admin.twig', array('carouselImages'=> $carouselImages, 'allCarouselImages'=> $allCarouselImages));
    }
}