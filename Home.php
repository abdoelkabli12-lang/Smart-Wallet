<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Money Track</title>
  <link rel="shortcut icon" href="297-2977261_wallet-budget-tracker-budgetbakers-icon-app.png" type="image/png">
  <link rel="icon" href="297-2977261_wallet-budget-tracker-budgetbakers-icon-app.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="/dist/styles/webawesome.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body class="m-0 font-sans antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 "> 


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>






  
  <style>

    #incomes-btn {
      background-color: rgba(38, 255, 0, 1);
    }

    .button {
      position: relative;
      transition: all 0.3s ease-in-out;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      padding-block: 0.5rem;
      padding-inline: 1.25rem;
      background-color: rgba(255, 0, 0, 1);
      border-radius: 9999px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffff;
      gap: 10px;
      font-weight: bold;
      border: 3px solid #ffffff4d;
      outline: none;
      overflow: hidden;
      font-size: 15px;
      cursor: pointer;
    }

    .icon {
      width: 24px;
      height: 24px;
      transition: all 0.3s ease-in-out;
    }

    .button:hover {
      transform: scale(1.05);
      border-color: #fff9;
    }

    .button:hover .icon {
      transform: translate(4px);
    }

    .button:hover::before {
      animation: shine 1.5s ease-out infinite;
    }

    .button::before {
      content: "";
      position: absolute;
      width: 100px;
      height: 100%;
      background-image: linear-gradient(120deg,
          rgba(255, 255, 255, 0) 30%,
          rgba(255, 255, 255, 0.8),
          rgba(255, 255, 255, 0) 70%);
      top: 0;
      left: -100px;
      opacity: 0.6;
    }

    @keyframes shine {
      0% {
        left: -100px;
      }

      60% {
        left: 100%;
      }

      to {
        left: 100%;
      }
    }
  </style>



  <header class="relative">
    <div class=" flex gap-4 bg-gradient-to-r from-green-600 via-green-300 to-blue-600 h-14 w-full flex items-center">
      <h1 class="ml-4 font-semibold font-[Inter] text-2xl text-white">
        Smart Wallet
      </h1>
      <img src="2dde7ddf-9a38-400b-94d2-c90c14b33677.jpg" class="rounded-full object-fit w-12">
          <button id="Usser" class="absolute w-5 bg-gred h-12  right-5"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 128a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zm208 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0zM48 480c0-70.7 57.3-128 128-128l96 0c70.7 0 128 57.3 128 128l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8c0-97.2-78.8-176-176-176l-96 0C78.8 304 0 382.8 0 480l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8z"/></svg>
          </button>
        </div>

  </header>

<script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'press-start': ['"Press Start 2P"', 'cursive'],
            'K2D': ['"K2D"', 'cursive'],
          },
          colors: {
            myred: '#A63348',
            magenta: '#5F425F',
            myblue: '#3B4A6B',
            cyan: '#1B7C97',
            myblue: '#3B4A6B',
            gred: '#FF0000',
            legendary: '#FFD400',
            rare: '#0C0091',
            uncommon: '#00FF11',
            common: '#FFFFFF',
            tblue: '#1F2937',
            mygrey: '#6B7280',
            gblue: '#374151',
            stroke: '#4B5563',
            underbg: '#E5E7EB',
            grayish: '#374151',
            brownish: '#EEB76B',
            orangish: '#E2703A',
            redmagenta: '#9C3D54',
            dark_brown: '#310B0B',
          }
        }
      }
    }
  </script>

<script type="text/javascript" src="script.js"></script>
</body>
</html>