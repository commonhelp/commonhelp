<?php
namespace Commonhelp\Form;

final class FormEvents{
	
	const PRE_SUBMIT = 'form.pre_bind';
	
	const SUBMIT = 'form.bind';
	
	const POST_SUBMIT = 'form.post_bind';
	
	const PRE_SET_DATA = 'form.pre_set_data';
	
	const POST_SET_DATA = 'form.post_set_data';
	
	const BEFORE_FORM = 'form.before_form';
	
	const AFTER_FORM = 'form.after_form';
	
	const BEFORE_FIELDSET = 'form.before_fieldset';
	
	const AFTER_FIELDSET = 'form.after_fieldset';
	
	const BEFORE_FIELD = 'form.before_field';
	
	const AFTER_FIELD = 'form.after_field';
	
	const BEFORE_LABEL = 'form.before_label';
	
	const AFTER_LABEL = 'form.after_label';
	
	private function __construct(){
	}
}