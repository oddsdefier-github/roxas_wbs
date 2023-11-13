<style>
    .signout-loader {
        z-index: 11;
    }

    .signout-loader::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        backdrop-filter: blur(5px);
        z-index: -1;
    }
</style>

<div class="signout-loader h-screen w-screen hidden absolute z-50 gap-5">
    <div class="flex flex-col justify-center items-center text-center gap-3">
        <div class="login-loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <svg width="0" height="0" class="svg">
            <defs>
                <filter id="uib-jelly-ooze">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="3" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="ooze" />
                    <feBlend in="SourceGraphic" in2="ooze" />
                </filter>
            </defs>
        </svg>
        <style>
            .login-loader {
                --uib-size: 60px;
                --uib-color: red;
                --uib-speed: 2.6s;
                --uib-dot-size: calc(var(--uib-size) * 0.23);
                position: relative;
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: var(--uib-size);
                height: var(--uib-dot-size);
                filter: url('#uib-jelly-ooze');
            }

            .dot {
                position: absolute;
                top: calc(50% - var(--uib-dot-size) / 2);
                left: calc(0px - var(--uib-dot-size) / 2);
                display: block;
                height: var(--uib-dot-size);
                width: var(--uib-dot-size);
                border-radius: 50%;
                background-color: var(--uib-color);
                animation: stream var(--uib-speed) linear infinite both;
                transition: background-color 0.3s ease;
            }

            .dot:nth-child(2) {
                animation-delay: calc(var(--uib-speed) * -0.2);
            }

            .dot:nth-child(3) {
                animation-delay: calc(var(--uib-speed) * -0.4);
            }

            .dot:nth-child(4) {
                animation-delay: calc(var(--uib-speed) * -0.6);
            }

            .dot:nth-child(5) {
                animation-delay: calc(var(--uib-speed) * -0.8);
            }

            @keyframes stream {

                0%,
                100% {
                    transform: translateX(0) scale(0);
                }

                50% {
                    transform: translateX(calc(var(--uib-size) * 0.5)) scale(1);
                }

                99.999% {
                    transform: translateX(calc(var(--uib-size))) scale(0);
                }
            }
        </style>
        <!-- <div>
            <p id="loading-message" class="font-medium text-lg text-indigo-700">Signing in..</p>
        </div> -->
    </div>
</div>