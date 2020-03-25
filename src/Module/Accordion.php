<?php

namespace BootstrapTemplate\Module;

class Accordion {
	private $args;
	private $content = array();

	function __construct( $args = array() ) {
		$this->args = array_merge(array(
			'id'          => 'accordion',
			'active'      => '',
			'active-class' => 'in show',
		), $args);
	}

	private function addTitle( $name, $title, $active ) {
		$attrs = array(
			'data-toggle'   => "collapse",
			'id'            => "$name-heading",
			'class'         => "btn btn-link",
			'href'          => "#$name",
			'data-target'   => "#$name",
			'aria-controls' => $name,
		);

		if( $active ) {
			$attrs['aria-expanded'] = "true";
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->content, sprintf('<a %s>%s</a>', implode(' ', $attrs), $title) . "\n");
	}

	private function addContent( $name, $title, $content, $active ) {
		$attrs = array(
			'id'              => $name,
			'class'           => "collapse",
			'aria-labelledby' => "$name-heading",
			'data-parent'     => "#" . $this->args['id'],
		);

		if( $active ) {
			$attrs['class'] .= ' ' . $this->args['active-class'];
		}

		ob_start();
		if( is_callable($content) ) {
			call_user_func($content, $name, $title);
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->content, sprintf('<div %s>%s</div>', implode(' ', $attrs), ob_get_clean()) . "\n");
	}

	public function addItem( $name, $title, $content ) {
		$active = $name === $this->args['active'];

		$this->addTitle( $name, $title, $active );
		$this->addContent( $name, $title, $content, $active );
		return $this;
	}

	public function render() {
		?>
		<div class="accordion" id="<?= $this->args['id'] ?>">
			<?= implode("\n", $this->content) ?>
		</div>
		<?php
	}
}
