<?php
namespace WPMSubscriberPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class WPMSubscriberForm extends Widget_Base {

	public function get_name() {
		return 'wpmsems-subscriber-form';
	}

	public function get_title() {
		return __( 'Subscriber Form', 'simple-email-mailchimp-subscriber' );
	}

	public function get_icon() {
		return 'fa fa-envelope';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Subscriber Form Content', 'simple-email-mailchimp-subscriber' ),
			]
		);

		$this->add_control(
			'wpmsems_form_id',
			[
				'label' => __( 'Form ID', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '102448', 'simple-email-mailchimp-subscriber' ),
			]
        );
        
		$this->add_control(
			'wpmsems_form',
			[
				'label' => __( 'Subscriber Form', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'102448' => __( 'Default', 'simple-email-mailchimp-subscriber' )
				],			
				'separator' => 'none',
			]
		);
      
		$this->end_controls_section();
        
        

        // Subscriber Form
		$this->start_controls_section(
			'wpmsems_subscriber_form_style',
			[
				'label' => __( 'Subscriber Form', 'simple-email-mailchimp-subscriber' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'wpmsems_form_width',
			[
				'label' => __( 'Width', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wpmsems_form_border',
                'selector' => '{{WRAPPER}} .wpmsems-elementor-form-widget',
            ]
        );
        $this->add_responsive_control(
            'wpmsems_form_border_radius',
            [
                'label' => __( 'Form Border Radius', 'simple-email-mailchimp-subscriber' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpmsems-elementor-form-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   
                ],
            ]
        );            
		$this->add_responsive_control(
			'wpmsems_form_padding',
			[
				'label' => __( 'Padding', 'plugin-name' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);         
		$this->add_responsive_control(
			'wpmsems_form_margin',
			[
				'label' => __( 'Margin', 'plugin-name' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);         
		$this->add_control(
			'wpmsems_form_bg_color',
			[
				'label' => __( 'Background Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget' => 'background: {{VALUE}};',
				],
			]
        );
        
		$this->add_control(
			'wpmsems_form_success_text_color',
			[
				'label' => __( 'Success Message Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #wpmsems_simple_result .wpmsems_success' => 'color: {{VALUE}};',
				],
			]
        ); 

        
		$this->add_control(
			'wpmsems_form_error_text_color',
			[
				'label' => __( 'Error Message Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #wpmsems_simple_result .wpmsems_error' => 'color: {{VALUE}};',
				],
			]
        ); 

        
		$this->add_control(
			'wpmsems_form_warning_text_color',
			[
				'label' => __( 'Warning Message Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #wpmsems_simple_result .wpmsems_warning' => 'color: {{VALUE}};',
				],
			]
        ); 

        
		$this->add_control(
			'wpmsems_form_process_text_color',
			[
				'label' => __( 'Process Message Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #wpmsems_simple_result span.wpmsems_process' => 'color: {{VALUE}};',
				],
			]
        ); 





        $this->end_controls_section();  
        
        // Subscriber Form Inputs
		$this->start_controls_section(
			'wpmsems_subscriber_form_input_style',
			[
				'label' => __( 'Subscriber Form Inputs', 'simple-email-mailchimp-subscriber' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

	
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wpmsems_form_input_border',
                'selector' => '{{WRAPPER}} .wpmsems-elementor-form-widget input',
            ]
        );
        $this->add_responsive_control(
            'wpmsems_form_input_border_radius',
            [
                'label' => __( 'Form Border Radius', 'simple-email-mailchimp-subscriber' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpmsems-elementor-form-widget input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   
                ],
            ]
        );            
		$this->add_responsive_control(
			'wpmsems_form_input_padding',
			[
				'label' => __( 'Padding', 'plugin-name' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);         
		$this->add_control(
			'wpmsems_form_input_bg_color',
			[
				'label' => __( 'Background Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// '.wtbmt_subscribe_tours button.wpmsems-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpmsems-elementor-form-widget input' => 'background: {{VALUE}};',
				],
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpmsems_form_input_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wpmsems-elementor-form-widget input',
			]
        );    
		$this->add_control(
			'wpmsems_form_input_text_color',
			[
				'label' => __( 'Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [				
					'{{WRAPPER}} .wpmsems-elementor-form-widget input' => 'color: {{VALUE}};',
				],
			]
        );            
        $this->end_controls_section();  
        




        // Subscriber Form Button
		$this->start_controls_section(
			'section_subscriber_content',
			[
				'label' => __( 'Subscriber Form Button', 'simple-email-mailchimp-subscriber' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_responsive_control(
            'wpmsems_form_button_position',
            [
                'label' => __( 'Alignment', 'simple-email-mailchimp-subscriber' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'simple-email-mailchimp-subscriber' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'simple-email-mailchimp-subscriber' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'simple-email-mailchimp-subscriber' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wpmsems-subscriber-form-button' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wpmsems_form_btn_border',
                'selector' => '{{WRAPPER}} .wpmsems-elementor-form-widget .wpmsems-subscriber-form-button button',
            ]
        );        
		$this->add_responsive_control(
			'wpmsems_button_padding',
			[
				'label' => __( 'Padding', 'plugin-name' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget .wpmsems-subscriber-form-button button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);        
		$this->add_control(
			'subs_button_bg_color',
			[
				'label' => __( 'Button Background Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget .wpmsems-subscriber-form-button button' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'subs_button_text_color',
			[
				'label' => __( 'Button Text Color', 'simple-email-mailchimp-subscriber' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpmsems-elementor-form-widget .wpmsems-subscriber-form-button button' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subs_btn_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wpmsems-elementor-form-widget .wpmsems-subscriber-form-button button',
			]
		);		
        $this->end_controls_section();  
        
        

	}

	protected function render() {
        global $wpmsems;
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'content', 'advanced' );
        $id					    = $settings['wpmsems_form_id'] ? $settings['wpmsems_form_id'] : 102448;
		$wpmsems_settings		= get_option('wpmsems_settings');
		$default_form			= $wpmsems_settings['wpmsems_subscriber_form'];
?>
<div class="wpmsems-subscriber-form-body wpmsems-elementor-form-widget">
    <?php do_action('wpmsems_before_subscriber_section',$id); ?>
	<div class="wpmsems-form-part wpmsems_simple_form_<?php echo $id; ?>">
	    <?php do_action('wpmsems_before_subscriber_result',$id); ?>
		<div id="wpmsems_simple_result"></div>
		<?php do_action('wpmsems_after_subscriber_result',$id); ?>
			<form action="" id='wpmsems_simple_form_<?php echo $id; ?>'>
					<?php
					if(!empty($default_form)){
					foreach ($default_form as $_form) {
						?>
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
							<label for="wpmsems_<?php echo $_form['form_inputs']; ?>">
								<?php echo $wpmsems->get_form_field($_form['label_text'],$_form['form_inputs']);  ?>					
							</label>
						</div>
						<?php
					}
				}else{
					?>
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
							<label for="wpmsems_email">
									<input required="" type="email" name="wpmsems_email" id="wpmsems_email" placeholder="<?php _e('Email','simple-email-mailchimp-subscriber'); ?>">									
							</label>
						</div>																	
						<div class="wpmsems-form-row wpmsems-subscriber-form-field">
                        <div class='wpmsems-subscriber-form-button'>
							<label for="wpmsems_submit">
										<button type="submit" class="btn btn-primary wpmsems-btn" id="wpmsems_default_submit"><?php _e('Subscriber Now','simple-email-mailchimp-subscriber'); ?></button>								
							</label>
                            </div>
						</div>
					<?php
				}
			?>
			</form>
</div>
<?php do_action('wpmsems_after_subscriber_section',$id); ?>
</div>
<?php
echo $wpmsems->wpmsems_ajax_js($id);
}

	protected function _content_template() {
	
	}
}
