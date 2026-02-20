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
        .stories.carousel .story>.item-link>.item-preview {
            height: 100% !important;
        }
        .stories.carousel .story>.item-link {
                height: 110px !important;
                width: 105px !important;

        }
        .stories .story > .item-link > .item-preview {
            width: 100% !important
        }
        #stories-wrapper {
            width: 100% !important;
        }
        #stories-wrapper .story {
            width: 100% !important;
            margin-right: 20px;
        }
        #stories-wrapper .story .item-preview {
            border-radius: 12px ;
        }
        #stories-wrapper .story .item-preview img {
            border-radius: 10px ;
        }
        .stories.carousel .story>.item-link>.info {
            color: #fff;
            
        }
        #zuck-modal {
    z-index: 10000 !important;
}
.delete-story-btn{
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 20px;
    cursor: pointer;
    z-index: 9999;
}
button .ff-btn{
    transition: transform 0.2s ease;
}

button.processing i{
    transform: scale(0.8);
}
    </style>