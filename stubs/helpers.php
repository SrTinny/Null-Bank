<?php
namespace Illuminate\View {
	class View {}
}

namespace Illuminate\Http {
	class RedirectResponse {
		/**
		 * Accept route name and optional parameters
		 * @param string $name
		 * @param mixed $params
		 */
		public function route($name, $params = null) { return $this; }
		public function with($k, $v) { return $this; }
	}
}

namespace Illuminate\Routing {
	use Illuminate\Http\RedirectResponse;
	class Redirector {
		/**
		 * @param string $name
		 * @param mixed $params
		 */
		public function route($name, $params = null): RedirectResponse { return new RedirectResponse(); }
	}
}

namespace {
	use Illuminate\View\View;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Routing\Redirector;

	function view($name, $data = []): View { return new View(); }
	function redirect(): Redirector { return new Redirector(); }
}
