document.addEventListener('DOMContentLoaded', function () {
    const pickerArrival = new easepick.create({
        element: '#arrival',
        css: ['bundles/rapidskeleton/frontend/css/easypick.min.css'],
        zIndex: 10,
        lang: 'de-DE',
        format: 'DD.MM.YYYY',
        LockPlugin: {
            minDate: new Date(),
            minDays: 1,
            selectForward: true,
        },
        RangePlugin: {
            elementEnd: '#departure',
        },
        plugins: ['RangePlugin', 'LockPlugin'],
        // setup(pickerArrival) {
        //     pickerArrival.on('select', (e) => {
        //         const { view, date, target } = e.detail;
        //     });
        // },
    });
});
