import { useState } from "react";

export default function Avatar({image, user, size, email}) {
    const [failImage, setFailImage] = useState(false);

    const handleFallback = (e) => {
        e.target.onerror = null;
        setFailImage(true);
    }
    return (
        <>
            {!failImage ? (<img id="avatarButton" role="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" className="w-10 h-10 rounded-full cursor-pointer" src={image} alt="User dropdown" onError={handleFallback}/>) : (<div id="avatarButton" role="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" className="w-10 h-10 rounded-full cursor-pointer bg-gray-300 flex items-center justify-center">{user[0]}</div>)}

            <div id="userDropdown" className="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <div className="px-4 py-3 text-sm text-gray-900 dark:text-white">
                <div>{user}</div>
                    <div className="font-medium truncate">{email}</div>
                </div>
                <ul className="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                    <li>
                        <a href="#" className="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                </ul>
                <div className="py-1">
                    <a href="#" className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                </div>
            </div>
        </>
    )
}