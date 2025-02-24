<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Christmas Jungle Parallax</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #1a3d1a;
            color: white;
            font-family: Arial, sans-serif;
        }
        .parallax-container {
            position: relative;
            height: 300vh;
        }
        .section {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 2rem;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        .snow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: url('https://unsplash.com/photos/femvMKBOwlo/download?w=1000'); /* Snow overlay */
            opacity: 0.6;
            pointer-events: none;
        }
        .trees {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 50vh;
            background: url('https://unsplash.com/photos/_2xtU-X6_lg/download?w=1000'); /* Christmas trees */
            background-size: cover;
        }
        .lights {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 30vh;
            background: url('https://unsplash.com/photos/MP0bgaS_d1c/download?w=1000'); /* Christmas lights */
            background-size: cover;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="parallax-container">
        <div class="background" style="background-image: url('https://unsplash.com/photos/VV1avpD3M3g/download?w=1000');"></div> <!-- Snowy jungle -->
        <div class="snow"></div>
        <div class="lights"></div>
        <div class="trees"></div>
        <div class="section">Merry Christmas in the Jungle!</div>
    </div>

    <script>
        gsap.registerPlugin(ScrollTrigger);
        
        gsap.to(".background", {
            scale: 1.2,
            scrollTrigger: {
                scrub: true
            }
        });

        gsap.to(".snow", {
            y: 100,
            opacity: 0.5,
            scrollTrigger: {
                scrub: true
            }
        });

        gsap.to(".lights", {
            y: -50,
            opacity: 1,
            scrollTrigger: {
                scrub: true
            }
        });
    </script>
</body>
</html>
