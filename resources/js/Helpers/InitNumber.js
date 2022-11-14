const InitNumber = {
  numberFormat(value) {
    if (value != null) {
      if (value.toString()[0] == "-") {
        var negative = "-";
      } else {
        negative = "";
      }
      var raw = value.toString().replace(/(?!\.)\D/g, "").split(".");
      var whole = raw[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      var decimal = false;
      if (raw.length > 1) {
        decimal = raw[1];
      }
      if (decimal !== false && (decimal !== "0" || decimal !== "00")) {
        return negative + whole + "." + decimal;
      } else {
        return negative + whole;
      }
    }
  },

  bindNumberFormat() {
    let listInputNumber = document.querySelectorAll(".number-format");
    for (let i = 0; i < listInputNumber.length; i++) {
      listInputNumber[i].addEventListener("keyup", function(e) {
        if (e.keyCode !== 6 && e.keyCode !== 46) {
          this.value = InitNumber.numberFormat(this.value);
        }
      });

      listInputNumber[i].value = InitNumber.numberFormat(listInputNumber[i].value);
    }
  }
};

document.addEventListener("DOMContentLoaded", function() {
  InitNumber.bindNumberFormat();
});