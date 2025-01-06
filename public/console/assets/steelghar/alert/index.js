"use strict";

// Class definition
let CrmMainNotifications = function () {

    const notificationBody = document.getElementById('notificationBody');
    const loader = document.getElementById('loader');
    let isNeedFetch = true;
    let link = BASE_URL + '/alerts/?page=1';
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            if (isNeedFetch) infinteLoadMoreNotifications(link);
        }
    });

    const setNotificationBody = (notifications) => {

        console.log(notifications)
        let n = '';
        notifications.forEach(notification => {

            n += `<div class="mb-5 col-md-4 "><div class=""><div class="p-3 rounded bg-white text-dark fw-semibold text-start" data-kt-element="message-text"><div class="d-flex flex-stack flex-wrap"><span class="badge badge-light-info fw-bold my-2">${notification.title}</span><div class="d-flex align-items-center pe-2"><div class="fs-8 fw-bold"><span class="text-muted">${notification.date}</span></div></div></div>${notification.message}</div></div></div>`;
        });

        console.log(n)
        notificationBody.insertAdjacentHTML('beforeend', n);
    }

    const infinteLoadMoreNotifications = (url) => {
        axios.get(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (response) {
                if (response.data.status == 'success') {
                    let notifications = response.data.notifications.data;
                    if (response.data.notifications.to) setNotificationBody(notifications);
                    if (response.data.notifications.next_page_url) {
                        link = response.data.notifications.next_page_url;
                    } else {
                        isNeedFetch = false;
                        loader.removeAttribute('data-kt-indicator');
                    }

                }
            })
            .catch(function (error) {

            })
            .finally(function () {
                // loader.classList.add('d-none');
            });
    }



    return {
        init: function () {
            infinteLoadMoreNotifications(link);
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    CrmMainNotifications.init();
});