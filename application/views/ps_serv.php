<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precision Manufacturing Process</title>
    
    <style>
        /* 1. Base Setup */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        
        :root {
            --primary-blue: #1e40af;
            --light-blue: #bfdbfe; /* For border-blue-100 */
            --gray-600: #4b5563;
            --gray-700: #374151;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 3rem 1rem 5rem 1rem; /* pt-12 pb-20 px-4 */
            margin: 0;
        }

        .main-wrapper {
            max-width: 80rem; /* max-w-5xl (approx) */
            margin: 0 auto; /* mx-auto */
        }
        /* 3. Callout Row (Mobile-first: Column Layout) */
        .callout-row {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3rem; /* space-y-12 */
        }
        
        .callout-box {
            width: 100%;
            text-align: left;
            order: 2; /* order-2 */
        }
        
        .callout-box h2 {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }
        
        .callout-box p {
            color: var(--gray-700);
        }

        /* 4. Illustration Center */
        .illustration-center {
            width: 100%;
            max-width: 36rem; /* max-w-xl */
            margin: 0 auto;
            height: 24rem; /* h-[24rem] */
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            order: 1; /* order-1 */
        }

        .illustration-image {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .illustration-image:nth-child(1) { z-index: 10; top: 0rem; } /* Top Mold */
        .illustration-image:nth-child(2) { z-index: 20; top: 10rem; } /* Internal Part */
        .illustration-image:nth-child(3) { z-index: 0; top: 17rem; } /* Bottom Mold */


        /* 5. Callout Lines (Desktop Only) */
        .rotated-line {
            position: absolute;
            transform-origin: 0 0;
        }

        /* Left Line (Silicone Mold) */
        .rotated-line-left {
            width: 9rem; /* w-36 */
            height: 1px;
            background-color: var(--primary-blue);
            /* These styles are applied via media query below */
        }

        /* Right Line (Urethane Part) */
        .rotated-line-right {
            width: 12rem; /* w-48 */
            height: 1px;
            background-color: var(--primary-blue);
            /* These styles are applied via media query below */
        }

        .rotated-dot {
            width: 0.5rem; /* w-2 */
            height: 0.5rem; /* h-2 */
            border-radius: 50%; /* rounded-full */
            background-color: var(--primary-blue);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        /* 6. Desktop Styles (md: Breakpoint) */
        @media (min-width: 768px) {
            .callout-row {
                flex-direction: row; /* md:flex-row */
                gap: 3rem; /* md:space-x-12 (approx) */
                gap-y: 0; /* md:space-y-0 */
            }

            .left-callout-box {
                width: 33.3333%; /* md:w-1/3 */
                order: 1; /* md:order-1 */
                align-self: flex-start; /* self-start */
                margin-top: 4rem; /* Custom alignment to match the line's top position */
                text-align: right; /* md:text-right */
                padding-right: 3rem; /* md:pr-12 */
            }

            .right-callout-box {
                width: 33.3333%; /* md:w-1/3 */
                order: 3; /* order-3 */
                align-self: flex-start; /* self-start */
                margin-top: 10rem; /* Custom alignment to match the line's top position */
                padding-left: 3rem; /* md:pl-12 */
            }

            .illustration-center {
                order: 2; /* md:order-2 */
            }

            /* Show callout lines */
            .callout-lines-container {
                display: block !important;
            }

            /* Left Line Position */
            .rotated-line-left {
                top: 13rem;
                left: -4rem;
                transform: rotate(-10deg);
            }
            .rotated-line-left .rotated-dot {
                right: 0;
                transform: translate(50%, -50%);
            }

            /* Right Line Position - FIX APPLIED HERE */
            .rotated-line-right {
                top: 21rem; /* Adjusted from 11rem to 10.5rem for better visual alignment with the text and image */
                right: -3.5rem;
                transform: rotate(5deg);
            }
            .rotated-line-right .rotated-dot {
                left: 0;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
 <section id="our-process-section">
        <!-- Header Section -->

            <h1 class="main-heading">
                WHAT DO WE DO
            </h1>
            <p class="sub-heading">
                Precision-crafted parts through Silicone Molding and Urethane Casting.
            </p>

        <!-- Main Illustration and Callout Container -->
        <div class="callout-row">
            
            <!-- Left Callout Box (Silicone Mold) -->
            <div class="callout-box left-callout-box">
                <div id="callout-left">
                    <br><br><br><h2>Silicone Mold</h2>
                    <p>Flexible, high-detail molds that capture even the most intricate surface textures.</p>
                </div>
            </div>

            <!-- Central Illustration Stack -->
            <div id="illustration-center" class="illustration-center">
                
                <!-- 1. Top Mold Image -->
                <img src="<?= base_url('assets_system/images/sm1.png')?>" 
                     alt="Top half of the silicone mold" 
                     class="illustration-image">

                <!-- 2. Internal Urethane Part Image -->
                <img src="<?= base_url('assets_system/images/sm2.png')?>" 
                     alt="The finished urethane part" 
                     class="illustration-image">

                <!-- 3. Bottom Mold Image -->
                <img src="<?= base_url('assets_system/images/sm3.png')?>" 
                     alt="Bottom half of the silicone mold" 
                     class="illustration-image">


                <!-- The Visual Callout Lines (Desktop Only) -->
                <div class="callout-lines-container hidden">
                    
                    <!-- Line 1: Left Callout to TOP MOLD -->
                    <div class="rotated-line rotated-line-left">
                        <div class="rotated-dot"></div>
                    </div>

                    <!-- Line 2: Right Callout to INTERNAL PART -->
                    <div class="rotated-line rotated-line-right">
                        <div class="rotated-dot"></div>
                    </div>
                </div>

            </div>
            
            <!-- Right Callout Box (Urethane Part) -->
            <div class="callout-box right-callout-box">
                <div id="callout-right">
                    <br><br><br><br><br><br><h2>Urethane Part</h2>
                    <p>Durable, functional, and production-grade.</p>
                </div>
            </div>

        </div>
     </section>
    </div>
</body>
</html>