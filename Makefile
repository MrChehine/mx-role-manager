CURRENT_DIR=$(shell pwd)

sandbox: sandbox.php
	##docker run -it --rm --name phpcli -v $(CURRENT_DIR):/app -w /app mxrolemanager-app:latest php sandbox.php
	docker-compose run --rm app php /app/sandbox.php