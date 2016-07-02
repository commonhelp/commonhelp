<?php
namespace Commonhelp\Form;

interface FormFactoryInterface{
	
	/**
	 * Builds the form.
	 *
	 * This method is called for each type in the hierarchy starting from the
	 * top most type. Type extensions can further modify the form.
	 *
	 *
	 * @param FormCreator $builder The form builder
	 * @param array                $options The options
	 */
	public function buildForm(FormCreator $builder, array $options);
	
	/**
	 * Configures the options for this type.
	 *
	 * @param OptionsResolver $resolver The resolver for the options
	*/
	//public function configureOptions(OptionsResolver $resolver);
}