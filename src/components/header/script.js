window.addEventListener('load', function () {

	const arrow = document.querySelector('.hero-arrow')
	arrow.addEventListener('click', ()=>{
		document.querySelector('.why').scrollIntoView()
	})

	const reviews = document.querySelectorAll('.js-splide-review')


	const config = {
		root: null, // Sets the framing element to the viewport
		rootMargin: "200px",
		threshold: 0.5
	}


	const sliderObserver = new IntersectionObserver((entries, observer) =>{
		entries.forEach(el=>{
			if(el.isIntersecting){
				if(el.target.classList.contains('inited')) {
					return
				}

				let splideRoof = new Splide(el.target, {
					// type: 'loop',
					lazy: 'sequential',
					perPage: 2,
					perMove: 1,
					gap: '2.4rem',
					drag: true,
					speed: 1000,
					pagination: true,
					arrows: true,
					lazyLoad: 'sequential',
					breakpoints:{
						575:{
							perPage: 1,
							arrows: false
						}
					}

				}).mount();

				el.target.classList.add('inited');

			}
		}, config)
	})


	reviews.forEach(el=>{

		sliderObserver.observe(el)
	})


	document.addEventListener('scroll', () => {
		if (window.pageYOffset > window.innerHeight) {
			document.querySelector('.back-to-top')?.classList.add('active');
		} else {
			document.querySelector('.back-to-top')?.classList.remove('active');
		}
	})

	document.querySelector('.back-to-top')?.addEventListener('click', () => {
		window.scrollTo({
			top: 0,
			behavior: 'smooth'
		})
	})

	function openPopup(target_url, win_name, width, height) {
		let socWinOpen = window.open(target_url, win_name, 'scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width='+width+',height='+height+',screenX='+((screen.width-width) / 2)+",screenY="+((screen.height-height) / 2)+",top="+((screen.height-height) / 2)+",left="+((screen.width-width) / 2));
		socWinOpen.focus();
	}

	const buyBtns = document.querySelectorAll('.js-btn-buy')
	if (buyBtns.length){
		buyBtns.forEach(btn=>{
			btn.addEventListener('click', async ()=>{
				const price = btn.dataset.price


				try {
					const response = await fetch(`https://tmdesign.by/payment.php?amount=${price}`, {

					})
					const {formUrl, ...rest} = await response.json()

					if(formUrl){
						openPopup(formUrl, 'Оплата' ,460, 700)
					}

					console.log(rest)
				} catch (e) {
					console.log(e)
				}


			})
		})
	}



})

