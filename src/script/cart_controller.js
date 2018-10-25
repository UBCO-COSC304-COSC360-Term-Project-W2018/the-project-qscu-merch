$(document).ready(function () {
    $('.cartProductAmount').on('change keyup paste', function () {
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    })
});
