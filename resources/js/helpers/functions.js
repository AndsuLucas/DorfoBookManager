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
    const loanAmount = parseInt(book.loan_amount);
    const total = parseInt(book.total);
    
    if (isNaN(total) || total < 0) {
        book.total = 1;
    }

    if (isNaN(loanAmount)) {
        book.loan_amount = 0;
    }

    if (loanAmount < 0 || loanAmount > total) {
        book.loan_amount = total;
    }


    if (book.title == undefined) {
        book.title = "";
    }

    book.title = book.title.toString().replace(/\d/, "");    
    book.remaining_amount = book.total - book.loan_amount;

};


