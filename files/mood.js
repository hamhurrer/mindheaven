(function () {
    angular
      .module('calendarApp', ['ngAnimate'])
      .controller('calendarController', calendarController);

    function calendarController($scope) {
        var vm = this;
        var now = new Date();
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var month = now.getMonth();
        var year = now.getFullYear();
        var monthDay = daysInMonth(month + 1, year);
        var n = now.getDate();
        var uidi, uidm, uid;

        vm.id = n.toString() + month.toString();
        vm.dataId;
        vm.events = [];
        vm.description;
        vm.type = '??';
        vm.month = months[month];
        vm.next = next;
        vm.prev = prev;
        vm.add = add;
        vm.toggleCompleted = toggleCompleted;

        vm.getStats = function () {
            var currentDate = parseInt(vm.id.slice(0, -1));
            var currentMonth = parseInt(vm.id.slice(-1));
            var stats = {
                '??': 0,
                '??': 0,
                '??': 0,
                '??': 0,
                '??': 0
            };
            for (var i = 0; i < vm.events.length; i++) {
                var eventDate = parseInt(vm.events[i].id.slice(0, -1));
                var eventMonth = parseInt(vm.events[i].id.slice(-1));
                if (eventMonth === currentMonth && eventDate >= currentDate - 6 && eventDate <= currentDate) {
                    stats[vm.events[i].type]++;
                }
            }
            return stats;
        };


        function placeIt() {
            var firstDay = new Date(year, month, 1).getDay();
            $(".date_item").first().css({
                'margin-left': (firstDay - 1) * 50 + 'px'
            });
        }


        function presentDay() {
            $(".date_item").eq(n - 1).addClass("present");
        }


        function showDays(days) {
            for (var i = 1; i < days; i++) {
                var uidi = i;
                var uidm = month;
                var uid = uidi.toString() + uidm.toString();
                $(".dates").append("<div class='date_item' data='" + uid + "'>" + i + "</div>");
            }
        }


        function daysInMonth(month, year) {
            return new Date(year, month, 0).getDate() + 1;
        }


        function next() {
            if (month < 11) {
                month++;
            } else {
                month = 0;
                year++;
            }
            $(".dates").html('');
            vm.month = months[month];
            monthDay = daysInMonth(month + 1, year);
            showDays(monthDay);
            placeIt();
        }

    
        function prev() {
            if (month === 0) {
                month = 11;
                year--;
            } else {
                month--;
            }
            $(".dates").html('');
            vm.month = months[month];
            monthDay = daysInMonth(month + 1, year);
            showDays(monthDay);
            placeIt();
        }

        
        function add() {
            vm.events.push({
                id: vm.id,
                description: vm.description,
                type: vm.type,
                completed: false
            });
            vm.description = "";
            $scope.$apply();
        }

        
        function toggleCompleted(event) {
            event.completed = !event.completed;
        }

        
        $(".dates").on("click", ".date_item", function () {
            vm.id = $(this).attr('data');
            vm.dataId = $(this).attr('data');
            $(this).addClass("present").siblings().removeClass("present");
            $scope.$apply();
        });

        showDays(monthDay);
        presentDay();
        placeIt();
    }
})();