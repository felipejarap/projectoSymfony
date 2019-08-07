<?php
 //src/AppBundle/Form/TaskType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //se visualisa los parametros del formulario con sus respectivas clases 
            //importando en use las extenciones
            ->add('fecha', DateTimeType::class)
            ->add('comensales', IntegerType::class, array ('label' => 'Numero de comensales'))   
            ->add('Observaciones', CKEditorType::class, array ('label' => 'Observaciones'))   
            ->add('guardar', SubmitType::class, ['label' => 'Reservar'])
        ;
    }
}