;'use strict';

window.addEventListener('DOMContentLoaded', function () {

  var form = document.getElementById('translator__form');
  var trs = form.querySelectorAll('tr');
  var inputs = form.querySelectorAll('input[type="text"]');
  var submitButton = form.querySelector('input[type="submit"]');

  // Highlighting a selected row

  trs.forEach(function (tr) {
    tr.addEventListener('click', function () {
      var selectedRow = form.querySelector('.translator__selected-row');
      if (selectedRow) {
        selectedRow.classList.remove('translator__selected-row');
      }
      this.classList.add('translator__selected-row');
    });
  });

  // Sending a form

  submitButton.addEventListener('click', function (event) {
    event.preventDefault();
    var data = '';
    var contactEmail =
      form
        .querySelector('#translator__form__contact-email input')
        .value;
    if (contactEmail) {
      data += 'contactEmail=' + contactEmail + '&';
    }
    var destinationLanguage =
      form
        .querySelector('#translator__form__destination-language input')
        .value;
    if (destinationLanguage) {
      data += 'destinationLanguage=' + destinationLanguage + '&';
    }
    var tables = form.querySelectorAll('.translator__form__table');
    tables.forEach(function (table) {
      var categoryName = table.getAttribute('data-category-name');
      table.querySelectorAll('input[type="text"]').forEach(function (input) {
        var sourcePhrase =
          input.parentElement.parentElement.querySelector('th').textContent;
        var translatedPhrase = input.value;
        translatedPhrase =
          translatedPhrase !== '' ? translatedPhrase : sourcePhrase;
        data +=
          'phrases[' + categoryName + '][' + sourcePhrase + ']='
          + translatedPhrase + '&'
      });
    });
    data += '_csrf=' + form.querySelector('[name="_csrf"]').value;
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('load', function () {
      var response = JSON.parse(this.responseText);
      if (response.success) {
        alert('Message sent');
      } else {
        alert('Something went wrong');
      }
      submitButton.removeAttribute('disabled');
      inputs.forEach(function (input) {
        input.removeAttribute('disabled');
      });
    });
    xhr.open('POST', '/translator');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    submitButton.setAttribute('disabled', true);
    inputs.forEach(function (input) {
      input.setAttribute('disabled', true);
    });

    xhr.send(data);
  });

});
