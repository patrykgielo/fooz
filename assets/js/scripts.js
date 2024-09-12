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

// Event listeners for the click event
// jQuery version (with safety check)
jQuery(document).ready(function($) {
    var $button = $('.js-get-books');
    if ($button.length) {
        $button.on('click', fetchBooksJQuery);
    }
});

