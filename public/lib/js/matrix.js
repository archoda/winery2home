(function() {

	'use strict';

	class Matrix
	{

		// Set Global Variables
		CTX 					= null;
		Canvas 					= null;
		Target 					= null;

		Font 					= 'Secular One';
		FontSizeMin 			= 20;
		FontSizeMax 			= 40;
		
		ColorMin 				= '251, 116, 186';//'222, 31, 130';
		ColorMax 				= '251, 116, 186';//'213,213,213';//'255, 133, 148';
		
		Chars 					= '诶比西迪伊艾弗吉艾尺艾杰开艾勒艾马艾娜哦屁吉吾艾儿艾丝提伊吾维豆贝尔维艾克斯吾艾贼德あいうえおはひふへほかきくけこまみむめもさしすせそやゆよたちつてとらりるれろなにぬねのわゐんゑをアイウエオカキクケコガギグゲゴサシスセソザジズゼゾタチツテトダヂヅデドナニヌネノハヒフヘホバビブベボパピプペポマミムメモヤユヨラリルレロワヲン';
		
		VelocityMin 			= 10;
		VelocityMax 			= 40;
		
		Drops 					= [];
		DropsMin 				= 80;
		DropsMax 				= 120;

		// Class Constructor
		constructor()
		{
			
			// Report missing target requirement if not supplied.
			if (!arguments[0].Target)
			{
				console.log('Required Matrix Target placeholder element was not provided.')
				return;
			}

			this.Font 			= arguments[0].Font ?? this.Font;
			this.FontSizeMin 	= arguments[0].FontSizeMin ?? this.FontSizeMin;
			this.FontSizeMax 	= arguments[0].FontSizeMax ?? this.FontSizeMax;
			this.ColorMin 		= arguments[0].ColorMin ?? this.ColorMin;
			this.ColorMax 		= arguments[0].ColorMax ?? this.ColorMax;
			this.Chars 			= arguments[0].Chars ?? this.Chars;
			this.VelocityMin 	= arguments[0].VelocityMin ?? this.VelocityMin;
			this.VelocityMax 	= arguments[0].VelocityMax ?? this.VelocityMax;
			this.DropsMin 		= arguments[0].DropsMin ?? this.DropsMin;
			this.DropsMax 		= arguments[0].DropsMax ?? this.DropsMax;

			this.Target 		= arguments[0].Target;
			
			this.Canvas 		= document.createElement('canvas');

			this.CTX 			= this.Canvas.getContext("2d");

			this.Target.append(this.Canvas);

			this.Create();

			this.Rain();

			window.addEventListener('resize', () => 
				{ 
					
					this.Create();

					this.Rain();
				}
			);

		}

		Create()
		{	

			// let Ratio = window.innerWidth / window.innerHeight;
			// let Width = window.innerWidth * Ratio;
			// let Height = window.innerHeight / Ratio;

			this.Target.setAttribute('width', window.innerWidth + 'px');
			this.Target.setAttribute('height', window.innerHeight + 'px');
			this.Canvas.setAttribute('width', window.innerWidth + 'px');
			this.Canvas.setAttribute('height', window.innerHeight + 'px');

		}


		Rain()
		{
			//let Lines = Math.round(window.innerWidth / (this.FontSizeMax * .95)) * 2;
			let Lines = Math.round(window.innerWidth / (this.FontSizeMax)) * 1.15;
			
			this.CTX.clearRect(0, 0, window.innerWidth, window.innerHeight);

			if (this.Drops.length === 0)
			{

				for (let i = 0; i <= Lines; i++)
				{
					let vel = Math.floor(Math.random() * (this.VelocityMax - this.VelocityMin + .025)) + this.VelocityMin; 
					
					this.Drops.push(
						{ 
							'i' : i,
							'x' : Math.floor(Math.random() * (400 - -400 + 1)) + -400,
							'y' : i * (this.FontSizeMax),
							'font' : this.Font,
							'size' : this.Random({ 'min': this.FontSizeMin, 'max': this.FontSizeMax }),
							'color' : this.ColorMax,
							'colorTail' : this.ColorMin,
							'colorAlpha' : 1,
							'tail' : Math.floor(Math.random() * (this.DropsMax - this.DropsMin + 1)) + this.DropsMin,
							'velocity' : vel,
							'velocityReset' : vel
						}
					);

					this.Drop(this.Drops[i]);
				}
			}
			else
			{
				for (let i = 0; i <= Lines; i++)
				{
					this.Drop(this.Drops[i]);
				}
			}

			requestAnimationFrame(() => this.Rain());
		}


		Drop()
		{

			// Increase Velocity
			if (this.Drops[arguments[0].i].x < window.innerHeight + 500) 
			{
				this.Drops[arguments[0].i].velocity += 1.455;
			}
			// Reset velocity
			else
			{
				this.Drops[arguments[0].i].velocity = this.Drops[arguments[0].i].velocityReset;
			}


			let DropX = arguments[0].y;

			let DropY = this.Drops[arguments[0].i].x = 
							(this.Drops[arguments[0].i].x > window.innerHeight + 500) 
								? (Math.floor(Math.random() * (400 - -400 + 1)) + -400) + this.Drops[arguments[0].i].velocity
								: this.Drops[arguments[0].i].x += this.Drops[arguments[0].i].velocity;

			let DropChar = this.Drops[arguments[0].i].char = this.Char();

			let Droplet = {
				'size' : this.Drops[arguments[0].i].size,
				'font' : this.Drops[arguments[0].i].font,
				'char' : this.Char(),
				'charTail' : this.Tail(),
				'color': this.Drops[arguments[0].i].color,
				'colorAlpha' : this.Drops[arguments[0].i].colorAlpha,
				'x' : DropX,
				'y' : DropY,
			}

			// Set the lead
			this.Set(Droplet);


			//Set the lead tail
			for (let i = 0; i < this.Drops[arguments[0].i].tail; i++)
			{
				Droplet = {
					'size' : this.Drops[arguments[0].i].size,// - (i * .45),
					'font' : this.Drops[arguments[0].i].font,
					'char' : this.Char(),
					'color': this.Drops[arguments[0].i].colorTail,//'40, 19, 63',//
					'colorAlpha': 1 - .55 - (.0065 * i),
					'x' : DropX,
					'y' : DropY - (this.Drops[arguments[0].i].size * (i + 1))
				}

				this.Set(Droplet);
			}
		}


		Char()
		{
			let Random = Math.round(Math.random() * this.Chars.length);
			let Char = this.Chars[(Random !== this.Chars.length) ? Random : 0];

			return Char;
		}


		Set()
		{	
			// this.CTX.fillStyle = 'rgba(255,255,255,1)';
			// this.CTX.globalAlpha = 0.2;
			// this.CTX.fillRect(arguments[0].x - 8, arguments[0].y - 8 , arguments[0].size, arguments[0].size);
			// this.CTX.globalAlpha = 1;
			this.CTX.font = arguments[0].size + 'px ' + arguments[0].font;
			this.CTX.textAlign = "center"; 
			this.CTX.fillStyle = 'rgba(' + arguments[0].color + ',' + arguments[0].colorAlpha + ')';
			this.CTX.fillText(arguments[0].char, arguments[0].x, arguments[0].y);
		}


		Tail()
		{
			// TODO Manage tail....

			return this.Char();
		}


		Random()
		{
			
			return Math.floor(Math.random() * (arguments[0].max - arguments[0].min) + arguments[0].min); 
		}



	}


	window.addEventListener('DOMContentLoaded', () => 
		{

			const matrix = new Matrix(
								{ 
								  	Target: document.querySelector('.matrix'),
								  	Chars: '诶比西迪伊艾弗吉艾尺艾杰开艾勒艾马艾娜哦屁吉吾艾儿艾丝提伊吾维豆贝尔维艾克斯吾艾贼德あいうえおはひふへほかきくけこまみむめもさしすせそやゆよたちつてとらりるれろなにぬねのわゐんゑをアイウエオカキクケコガギグゲゴサシスセソザジズゼゾタチツテトダヂヅデドナニヌネノハヒフヘホバビブベボパピプペポマミムメモヤユヨラリルレロワヲン',
							  		FontSizeMin: 8,
									FontSizeMax: 12
								}
							);

		}
	);

})();