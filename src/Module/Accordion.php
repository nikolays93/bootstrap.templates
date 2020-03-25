<?php

namespace BootstrapTemplate\Module;

class Accordion {
	private $args;
	private $content = array();

	function __construct( $args = array() ) {
		$this->args = array_merge(array(
			'id'               => 'accordion',
			'active'           => '',
            'title-template'   => '<a %1$s>%2$s</a>',
            'title-class'      => 'btn btn-link',
            'title-active'     => 'active',
            'content-template' => '<div %1$s>%2$s</div>',
            'content-class'    => 'collapse',
			'content-active'   => 'in show',
		), $args);
	}

	private function addTitle( $name, $title, $active ) {
        $target = $this->args['id'] . "-$name";
		$attrs = array(
			'id'            => $this->args['id'] . "-$name-heading",
			'class'         => $this->args['title-class'],
            'href'          => "#$target",
			'data-toggle'   => "collapse",
			'data-target'   => "#$target",
			'aria-controls' => $name,
		);

        if( $active ) {
            $attrs['class'] .= ' ' . $this->args['title-active'];
            $attrs['aria-expanded'] = "true";
        }

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->content, sprintf($this->args['title-template'], implode(' ', $attrs), $title) . "\n");
	}

	private function addContent( $name, $title, $content, $active ) {
		$attrs = array(
			'id'              => $this->args['id'] . "-$name",
			'class'           => $this->args['content-class'],
			'aria-labelledby' => $this->args['id'] . "-$name-heading",
			'data-parent'     => "#" . $this->args['id'],
		);

		if( $active ) $attrs['class'] .= ' ' . $this->args['content-active'];

		ob_start();
		if( is_callable($content) ) {
			call_user_func($content, $name, $title);
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->content, sprintf($this->args['content-template'], implode(' ', $attrs), ob_get_clean()) . "\n");
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
