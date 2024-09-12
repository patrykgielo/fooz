console.log('Fooz Child Scripts');

// jQuery version
function fetchBooksJQuery() {
    jQuery.ajax({
        url: foozAjax.ajaxurl,
        type: 'POST',
        data: {
            action: 'get_books',
            nonce: foozAjax.nonce
        },
        success: function(response) {
            if (response.success) {
                displayBooksJQuery(response.data);
            } else {
                console.error('Error fetching books:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

function displayBooksJQuery(books) {
    var bookList = jQuery('#book-list');
    bookList.empty();

    books.forEach(function(book) {
        var genresHtml = '';
        if (book.genres && book.genres.length > 0) {
            genresHtml = '<p>Genres: ' + book.genres.map(function(genre) {
                return '<a href="' + genre.link + '">' + genre.name + '</a>';
            }).join(', ') + '</p>';
        }

        var bookHtml = '<div class="book">' +
            '<h3><a href="' + book.link + '">' + book.name + '</a></h3>' +
            '<p>Date: ' + book.date + '</p>' +
            genresHtml +
            '<p>' + book.excerpt + '</p>' +
            '</div>';
        bookList.append(bookHtml);
    });
}

// Vanilla JavaScript version
function fetchBooksVanilla() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', foozAjax.ajaxurl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                displayBooksVanilla(response.data);
            } else {
                console.error('Error fetching books:', response);
            }
        } else {
            console.error('AJAX error:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('AJAX error: Network error');
    };

    var data = 'action=get_books&nonce=' + encodeURIComponent(foozAjax.nonce);
    xhr.send(data);
}

function displayBooksVanilla(books) {
    var bookList = document.getElementById('book-list');
    bookList.innerHTML = '';

    books.forEach(function(book) {
        var genresHtml = '';
        if (book.genres && book.genres.length > 0) {
            genresHtml = '<p>Genres: ' + book.genres.map(function(genre) {
                return '<a href="' + genre.link + '">' + genre.name + '</a>';
            }).join(', ') + '</p>';
        }

        var bookHtml = '<div class="book">' +
            '<h3><a href="' + book.link + '">' + book.name + '</a></h3>' +
            '<p>Date: ' + book.date + '</p>' +
            genresHtml +
            '<p>' + book.excerpt + '</p>' +
            '</div>';
        bookList.insertAdjacentHTML('beforeend', bookHtml);
    });
}

// Event listeners for the click event
// jQuery version (with safety check)
jQuery(document).ready(function($) {
    var $button = $('.js-get-books');
    if ($button.length) {
        $button.on('click', fetchBooksJQuery);
    }
});

// Vanilla JavaScript version (with safety check)
// document.addEventListener('DOMContentLoaded', function() {
//     var button = document.querySelector('.js-get-books');
//     if (button) {
//         button.addEventListener('click', fetchBooksVanilla);
//     }
// });

