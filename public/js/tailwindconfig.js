tailwind.config = {
    darkMode: "class",

    theme: {
        extend: {
            colors: {
                clifford: "#da373d",
            },
            keyframes: {
                fadein: {
                    "0%": { opacity: 0 },
                    "100%": { opacity: 1 },
                },
            },
            animation: {
                fadein: "fadein 1s ease-in-out",
            },
        },
    },
};
