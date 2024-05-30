export function useTextTools() {
    const truncateText = (text, length) => {
        return text.length > length ? text.substring(0, length) + '...' : text;
    }

    const validateEmail = (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    const imagePathResource = (fileName, path)  => {
        return fileName.startsWith('http') || fileName.startsWith('blob') ? fileName : '/images/' + path + '/' + fileName
    }

    return {truncateText, validateEmail, imagePathResource};
}
