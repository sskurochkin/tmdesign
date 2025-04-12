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





})

