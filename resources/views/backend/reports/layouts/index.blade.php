<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="{{ asset("backend/admindashboard/my") }}/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
</head>
<body>





	@yield('content')





	<style type="text/css">

		body{
			font-family: 'lato';
			letter-spacing: 0.8px;
		}

		.invoice{
			background: #fff;
			padding: 30px;
			padding-top: 10px;

		}

		.invoice span{
			font-size: 15px;
		}

		thead{
			font-size: 14px;
		}

		tbody{
			font-size: 15px;
		}


		tbody {
			border: none !important;
		}

		tr{
			color:black;
		}
		td{
			color:black;
		}



		@media print
		{



		

			.print{
				display: none;
			}

			.invoice span{
				font-size: 22px;
			}
			/*@page  { size: 10cm 20cm landscape; }*/

		}

		/* latin-ext */
		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: 300;
			font-display: swap;
			src: url(https://fonts.gstatic.com/s/lato/v24/S6u9w4BMUTPHh7USSwaPGR_p.woff2) format('woff2');
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: 300;
			font-display: swap;
			src: url(https://fonts.gstatic.com/s/lato/v24/S6u9w4BMUTPHh7USSwiPGQ.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		/* latin-ext */
		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: 400;
			font-display: swap;
			src: url(https://fonts.gstatic.com/s/lato/v24/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: 400;
			font-display: swap;
			src: url(https://fonts.gstatic.com/s/lato/v24/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}


	</style>


</body>
</html>