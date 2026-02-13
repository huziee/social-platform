 <style>
        .insta-slider {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .insta-track {
            display: flex;
            transition: transform 0.35s ease-in-out;
        }

        .insta-slide {
            min-width: 100%;
        }

        .insta-slide img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Arrows */
        .insta-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 5;
        }

        .insta-btn.prev {
            left: 10px;
        }

        .insta-btn.next {
            right: 10px;
        }

        .insta-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }
    </style>