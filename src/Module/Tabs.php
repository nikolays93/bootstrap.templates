<?php

namespace BootstrapTemplate\Module;

class Tabs {
	private $args;
	private $navs = array();
	private $content = array();

	function __construct( $args = array() ) {
		$this->args = array_merge(array(
			'id'          => 'nav-tabs',
			'active'      => '',
			'fade'        => true,
			'pane-active' => 'in active',
		), $args);
	}

	private function addTabListItem( $name, $title, $active ) {
		$attrs = array(
			'data-toggle'   => "tab",
			'class'         => "nav-item nav-link",
			'id'            => "nav-$name-tab",
			'href'          => "#nav-$name",
			'aria-controls' => "nav-$name",
			'aria-selected' => "false",
		);

		if( $active ) {
			$attrs['class'] .= ' active';
			$attrs['aria-selected'] = "true";
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->navs, sprintf('<a %s>%s</a>', implode(' ', $attrs), $title) . "\n");
	}

	private function addContent( $name, $title, $content, $active ) {
		$attrs = array(
			'class'           => "tab-pane",
			'id'              => "nav-$name",
			'role'            => "tabpanel",
			'aria-labelledby' => "nav-$name-tab",
		);

		if($this->args['fade']) {
			$attrs['class'] .= ' fade';
		}

		if( $active ) {
			$attrs['class'] .= ' ' . $this->args['pane-active'];
		}

		ob_start();
		if( is_callable($content) ) {
			call_user_func($content, $name, $title);
		}

		array_walk($attrs, function( &$value, $key ) { $value = "$key=\"$value\""; });
		array_push($this->content, sprintf('<div %s>%s</div>', implode(' ', $attrs), ob_get_clean()) . "\n");
	}

	public function addTab( $name, $title, $content ) {
		$active = $name === $this->args['active'];

		$this->addTabListItem( $name, $title, $active );
		$this->addContent( $name, $title, $content, $active );
		return $this;
	}

	public function render() {
		?>
		<nav>
			<div class="nav nav-tabs" id="<?= $this->args['id'] ?>" role="tablist">
				<?= implode("\n", $this->navs) ?>
			</div>
		</nav>

		<div class="tab-content" id="<?= $this->args['id'] ?>-content">
			<?= implode("\n", $this->content) ?>
		</div>
		<?php
	}
}
