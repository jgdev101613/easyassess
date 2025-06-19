<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 - Lost in SACLI</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      height: 100vh;
      background: url('assets/saclibg.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      text-align: center;
      color: white;
      animation: fadeIn 1.5s ease-out;
    }

    .glass-wrapper {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 2rem;
      padding: 2rem;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      animation: slideIn 1.2s ease-in-out;
    }

    h1 {
      font-size: 5rem;
      color: #fff;
      text-shadow: 0 0 10px #00c3ff, 0 0 30px #00c3ff;
      animation: popUp 0.6s ease-out;
    }

    p {
      font-size: 1.2rem;
      margin-top: 1rem;
      color: #eee;
      line-height: 1.6;
      text-shadow: 0 1px 2px #000;
    }

    .ghost {
      width: 120px;
      height: 120px;
      background: white;
      border-radius: 60% 60% 0 0;
      position: relative;
      margin: 2rem auto 1rem;
      animation: floatGhost 3s infinite ease-in-out;
    }

    .ghost::before,
    .ghost::after {
      content: '';
      position: absolute;
      background: white;
      border-radius: 50%;
    }

    .ghost::before {
      width: 20px;
      height: 20px;
      top: 35px;
      left: 15px;
    }

    .ghost::after {
      width: 20px;
      height: 20px;
      top: 35px;
      right: 15px;
    }

    .ghost-eyes {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 15px;
    }

    .eye {
      width: 10px;
      height: 10px;
      background: black;
      border-radius: 50%;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes popUp {
      from { transform: scale(0); }
      to { transform: scale(1); }
    }

    @keyframes slideIn {
      0% {
        transform: translateY(40px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes floatGhost {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-15px);
      }
    }

    @media (max-width: 600px) {
      body {
        height: 100dvh;
      }
      h1 {
        font-size: 3.5rem;
      }

      p {
        font-size: 1rem;
      }

      .glass-wrapper {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="glass-wrapper">
    <h1>404</h1>
    <p>Oops... You’re not lost in life, just lost in SACLI’s cyberspace.<br><br>Even our ghost has no idea where this page went 👻</p>
    <div class="ghost">
      <div class="ghost-eyes">
        <div class="eye"></div>
        <div class="eye"></div>
      </div>
    </div>
  </div>
</body>
</html>