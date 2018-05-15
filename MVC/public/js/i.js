bannerPlay:function(){// 首页轮播图-渐变
        var banner = $('.front'),
            slides = banner.find('.banner-slide'),
            //dotContainer = banner.find('.banner-dots'),
            dotTpl = '',
            dots,
            total = slides.length,
            index = -1,
            duration = 500,
            interval = 5000,
            timer = null;

        if(total == 1) { // 一张图 不执行轮播
            next();
            return;
        }

        //dotTpl = '<span></span>';

        //$.each(slides, function(i, el){
         //   dotContainer.append(dotTpl);
        });

        //dots = dotContainer.find('span');

        function show(i){
            var cur = slides.filter('.slide-active');
            slides.stop(true, true);
            cur.removeClass('slide-active').fadeOut(600);
            slides.eq(i).addClass('slide-active').fadeIn(800);
            dots && dots.removeClass('active').eq(i).addClass('active');
        }
        function prev(){
            index--;
            index = index < 0 ? total - 1 : index;
            show(index);
        }

        function next(){
            index++;
            index = index > total - 1 ? 0 : index;
            show(index);
        }

        function autoPlay(){
            if(timer) clearInterval(timer);
            timer = setInterval(function(){
                next();
            }, interval);
        }

        banner.find('.banner-anchor').removeAttr('style');

        banner.on('click', '.prev', function(e){
            prev();
        }).on('click', '.next', function(e){
            next();
        }).on('click', '.banner-dots span', function(e){
            if($(this).hasClass('active')) return;
            var i = $(this).index();
            index = i;
            show(i);
        });

        banner.on('mouseenter', function(e){
            if(timer) clearInterval(timer);
        }).on('mouseleave', function(e){
            autoPlay();
        });

        next();
        autoPlay();
    
    }