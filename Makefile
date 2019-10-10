SRCDIR=test
DISTDIR=dist
VENDORDIR=vendor
LOCAL_SERVER=localhost
PORT=3000

clean:
	rm -rf ${DISTDIR}
p_cfg:
	cp .env.p.local.php ${SRCDIR}/env.php
dev_cfg:
	cp .env.dev.local.php ${SRCDIR}/env.php
build: clean
	mkdir -p dist
	cp -R ${SRCDIR}/ ${DISTDIR}/
	cp .env.p.local.php ${DISTDIR}/env.php
	cp -R ${VENDORDIR} ${DISTDIR}/
run_dev:
	php -S ${LOCAL_SERVER}:${PORT} -t ${SRCDIR}
run_dist:
	php -S ${LOCAL_SERVER}:${PORT} -t ${DISTDIR}
deploy: build
	ncftpput -f deploy.cfg -R -v / ${DISTDIR}/*
help:
	@echo "aphpi:"
	@echo "available targets:"
	@echo "clean   : clean"
	@echo "p_cfg   : set prd env to src dir"
	@echo "dev_cfg : set dev env to src dir"
	@echo "build   : build in dist dir"
	@echo "deploy  : deploy"
	@echo "help    : this help"
	@echo "run_dev : run dev server"
	@echo "run_dist: run dist server"