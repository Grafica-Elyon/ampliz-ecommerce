export default class MegaMenu {
	constructor() {
		this.initDesktop();
		this.initMobile();
	}

	initDesktop() {
		document.querySelectorAll('[data-megamenu]').forEach((menu) => {
			this.ligarAbertura(menu);

			menu.querySelectorAll('[data-familia]').forEach((botao) => {
				const trocar = () => this.selecionarFamilia(menu, botao.dataset.familia);

				botao.addEventListener('mouseenter', trocar);
				botao.addEventListener('click', (e) => {
					e.preventDefault();
					trocar();
				});
			});

			this.ligarAcordeao(menu);
		});

		window.addEventListener('resize', () => {
			clearTimeout(this.timerResize);
			this.timerResize = setTimeout(() => {
				document.querySelectorAll('[data-megamenu]').forEach((menu) => {
					delete menu.dataset.distribuido;
					this.distribuirTodos(menu);
				});
			}, 150);
		});
	}

	distribuirTodos(menu) {
		if (menu.offsetParent === null && !menu.classList.contains('is-open')) {
			delete menu.dataset.distribuido;

			return;
		}

		menu.querySelectorAll('[data-painel]').forEach((painel) => this.distribuir(painel));
		menu.dataset.distribuido = '1';
	}

	distribuir(painel) {
		const estilo = getComputedStyle(painel);
		const maximo = parseInt(estilo.getPropertyValue('--mp-colunas'), 10) || 1;
		const porColuna = parseInt(estilo.getPropertyValue('--mp-linhas-coluna'), 10) || 0;
		const blocos = Array.from(painel.querySelectorAll('.mp-megamenu__bloco'));

		if (!blocos.length) return;

		const colunas = this.quantasColunas(blocos.length, maximo, porColuna);

		const estavaOculto = !painel.classList.contains('is-active');
		if (estavaOculto) {
			painel.style.visibility = 'hidden';
			painel.classList.add('is-active');
		}

		painel.querySelectorAll('.mp-megamenu__coluna').forEach((c) => c.remove());

		const criadas = [];
		for (let i = 0; i < colunas; i++) {
			criadas.push(this.novaColuna(painel));
		}

		blocos.forEach((bloco) => criadas[0].appendChild(bloco));

		const alturas = blocos.map((bloco) => bloco.offsetHeight);
		const total = alturas.reduce((soma, altura) => soma + altura, 0);

		if (total === 0) {
			if (estavaOculto) {
				painel.classList.remove('is-active');
				painel.style.visibility = '';
			}

			return;
		}

		const alvo = total / colunas;

		let usadas = 1;
		let acumulado = 0;

		blocos.forEach((bloco, i) => {
			criadas[usadas - 1].appendChild(bloco);
			acumulado += alturas[i];

			const restantes = blocos.length - (i + 1);
			const livres = colunas - usadas;

			if (restantes > 0 && livres > 0 && (acumulado >= alvo || restantes <= livres)) {
				usadas++;
				acumulado = 0;
			}
		});

		if (estavaOculto) {
			painel.classList.remove('is-active');
			painel.style.visibility = '';
		}
	}

	quantasColunas(total, maximo, porColuna) {
		if (porColuna < 1) return maximo;

		return Math.min(maximo, Math.max(1, Math.ceil(total / porColuna)));
	}

	novaColuna(painel) {
		const coluna = document.createElement('div');
		coluna.className = 'mp-megamenu__coluna';
		painel.appendChild(coluna);

		return coluna;
	}

	ligarAbertura(menu) {
		const item = menu.closest('#products') || menu.parentElement;
		if (!item) return;

		let timer = null;

		const abrir = () => {
			clearTimeout(timer);
			menu.classList.add('is-open');

			if (!menu.dataset.distribuido) {
				this.distribuirTodos(menu);
			}
		};

		const fechar = () => {
			clearTimeout(timer);
			timer = setTimeout(() => menu.classList.remove('is-open'), 180);
		};

		[item, menu].forEach((alvo) => {
			alvo.addEventListener('mouseenter', abrir);
			alvo.addEventListener('mouseleave', fechar);
		});

		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape') menu.classList.remove('is-open');
		});
	}

	selecionarFamilia(menu, familiaId) {
		menu.querySelectorAll('[data-familia]').forEach((b) => {
			const ativo = b.dataset.familia === familiaId;
			b.classList.toggle('is-active', ativo);
			b.setAttribute('aria-selected', ativo ? 'true' : 'false');
		});

		menu.querySelectorAll('[data-painel]').forEach((p) => {
			p.classList.toggle('is-active', p.dataset.painel === familiaId);
		});
	}

	ligarAcordeao(escopo) {
		const linhas = escopo.querySelectorAll(
			'.mp-megamenu__item--raiz, .mp-megamenu-mobile__item'
		);

		linhas.forEach((linha) => {
			const botao = linha.querySelector('[data-expandir]');

			if (!botao) return;

			linha.classList.add('tem-expansao');

			linha.addEventListener('click', (e) => {
				if (e.target.closest('a')) return;

				e.preventDefault();
				e.stopPropagation();

				this.alternarAcordeao(botao);
			});
		});
	}

	alternarAcordeao(botao) {
		const bloco = botao.closest('.mp-megamenu__bloco, .mp-megamenu-mobile__grupo');
		if (!bloco) return;

		const aberto = botao.getAttribute('aria-expanded') === 'true';

		botao.setAttribute('aria-expanded', aberto ? 'false' : 'true');
		bloco.classList.toggle('is-open', !aberto);
	}

	initMobile() {
		document.querySelectorAll('[data-megamenu-mobile]').forEach((menu) => {
			const item = menu.closest('.menu-item') || menu.parentElement;
			const gatilho = item && item.querySelector('a');

			if (gatilho) {
				gatilho.classList.add('mp-megamenu-mobile__gatilho');

				const seta = document.createElement('span');
				seta.className = 'mp-megamenu-mobile__seta';
				gatilho.appendChild(seta);

				gatilho.addEventListener('click', (e) => {
					e.preventDefault();
					e.stopPropagation();

					const aberto = menu.classList.toggle('is-open');
					gatilho.classList.toggle('is-open', aberto);
				});
			}

			menu.querySelectorAll('[data-abrir-familia]').forEach((botao) => {
				botao.addEventListener('click', (e) => {
					e.preventDefault();
					const alvo = botao.dataset.abrirFamilia;

					menu.querySelectorAll('[data-painel-mobile]').forEach((painel) => {
						painel.classList.toggle('is-active', painel.dataset.painelMobile === alvo);
					});
				});
			});

			menu.querySelectorAll('[data-voltar]').forEach((botao) => {
				botao.addEventListener('click', (e) => {
					e.preventDefault();
					const painel = botao.closest('[data-painel-mobile]');
					if (painel) painel.classList.remove('is-active');
				});
			});

			menu.querySelectorAll('[data-fechar]').forEach((botao) => {
				botao.addEventListener('click', (e) => {
					e.preventDefault();

					menu.querySelectorAll('[data-painel-mobile]').forEach((p) =>
						p.classList.remove('is-active')
					);
					menu.classList.remove('is-open');

					const fecharGaveta = document.querySelector('.rh-close');
					if (fecharGaveta) fecharGaveta.click();
				});
			});

			this.ligarAcordeao(menu);
		});
	}
}
