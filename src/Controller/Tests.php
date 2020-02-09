<?php

namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Tests extends AbstractController
{
    /**
     * @Route("/tests", name="tests")
     */
    public function index()
    {

        $sql = "SELECT * FROM categories";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        var_dump($result);


        function ordered_list($array, $parent_id = null)
        {
            $temp_array = array();
            foreach ($array as $element) {
                if ($element['parent_id'] == $parent_id) {
                    $element['children'] = ordered_list($array, $element['id']);
                    $temp_array[] = $element;
                }
            }
            return $temp_array;
        }

      $rr=  ordered_list($result);

var_dump($rr);;

        return $this->render('tests/tests.html.twig', [
            'controller_name' => 'Tests',
            'repo' => $rr,
            'title' => 'tests'
        ]);
    }
}
