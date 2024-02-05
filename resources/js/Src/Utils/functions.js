const navigation = {
    openWindow: (url) => {
        let width = window.innerWidth * 0.5;
        let height = window.innerHeight * 0.5;
        window.open(url, "", `width=${width},height=${height}`);
    }
};

export {
    navigation
}
