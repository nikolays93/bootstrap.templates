<?php

namespace BootstrapTemplate\Module;

class Tabs {
	private $args;
	private $navs = array();
	private $content = array();

	function __construct( $args = array() ) {
		$this->args = array_merge(array(
			'id'               => 'tabs',
			'active'           => '',
            'title-template'   => '<a %1$s>%2$s</a>',
            'title-class'      => 'nav-item nav-link',
            'title-active'     => 'active',
            'content-template' => '<div %1$s>%2$s</div>',
            'content-class'    => 'tab-pane fade',
			'content-active'   => 'in show active',
		), $args);
	}

	private function addTitle( $name, $title, $active ) {
		$target = $this->args['id'] . "-$name";
		$attrs = array(
			'id'            => $this->args['id'] . "-$name-tab",
			'class'         => $this->args['title-class'],
			'href'          => "#$target",
			'data-toggle'   => "tab",
			'aria-controls' => $target,
			'aria-selected' => "false",
		);

		if( $active ) {
			$attrs['class'] .= ' ' . $this->args['title-active'];
			$attrs['aria-selected'] = "true";
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->navs, sprintf($this->args['title-template'], implode(' ', $attrs), $title) . "\n");
	}

	private function addContent( $name, $title, $content, $active ) {
		$attrs = array(
			'id'              => $this->args['id'] . "-$name",
			'class'           => $this->args['content-class'],
			'role'            => "tabpanel",
			'aria-labelledby' => $this->args['id'] . "-$name-tab",
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
		<nav class="nav nav-tabs" id="<?= $this->args['id'] ?>" role="tablist">
			<?= implode("\n", $this->navs) ?>
		</nav>

		<div class="tab-content" id="<?= $this->args['id'] ?>-content">
			<?= implode("\n", $this->content) ?>
		</div>
		<?php
	}
}
