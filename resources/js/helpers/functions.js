export const validateBookData = (book) => {
    const loan_amount = book.loan_amount;
    const remaining_amount = book.remaining_amount;
    const total = book.total;
    const title = book.title;

    if ((loan_amount < 0 || total < 0 || remaining_amount < 0)) {
        return 'Atente-se: Os valores não podem ser menores que 0.';
    }

    if (total == 0) {
        return 'Atente-se: O total não pode ser igual a 0';
    }

    if (loan_amount > total) {
        return 'Atente-se: A quantidade emprestada não pode ser maior que o total.';
    
    }

    if (remaining_amount > total) {
        return 'Atente-se: A quantidade restante não pode ser maior que o total.';
    }

    const isEmptyTotal = (total.toString().trim().length == 0);
    
    if (isEmptyTotal) {
        return 'Atente-se: O total deve ser preenchido.';
    }

    const isEmptyTitle = (title.toString().trim().length == 0);

    if (isEmptyTitle) {
        return 'Atente-se: O título deve ser preeenchido.';
    }

    return '';
};

export const parseBookData = (book) => {
    book.loan_amount = isNaN(book.loan_amount) ? 0 : parseInt(book.loan_amount);
    book.remaining_amount = isNaN(book.remaining_amount) ? 0 : parseInt(book.remaining_amount);
    book.total = book.total == undefined || book.total <= 0 ? 1 : parseInt(book.total);
    book.title = book.title == undefined ? '' : book.title;
    book.remaining_amount = book.total - book.loan_amount;
    return book;
};

export const removeCachedBook = (bookId, callback) => {
       
}
