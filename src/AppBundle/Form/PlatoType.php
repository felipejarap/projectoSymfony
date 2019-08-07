<?php
 //src/AppBundle/Form/TaskType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PlatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //se visualisa los parametros del formulario con sus respectivas clases 
            //importando en use las extenciones
            ->add('nombre', TextType::class)
            ->add('descripcion', CKEditorType::class)
            ->add('ingredientes', EntityType::class, array ('class' => 'AppBundle:Ingrediente', 'multiple' => true))   
            ->add('categoria', EntityType::class, array ('class' => 'AppBundle:Categoria'))          
            ->add('foto', FileType::class, array('attr'=>array('onchange'=> 'onChange(event)')))
            ->add('top')
            ->add('guardar', SubmitType::class, ['label' => 'nuevo Plato'])
        ;
    }
}