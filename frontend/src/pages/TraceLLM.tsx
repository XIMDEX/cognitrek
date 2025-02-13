import Accordion from "../components/ui/Accordion"


export default function TraceLLM({ id }) {
    console.log(id)
    const label_adaption = 'Custom User + Demo Disylexic LOW + Attention deficit LOW + Custom user'
    
    return (
        <div className=" w-11/12 m-auto ">
            <h2 className="text-2xl text-center border-b-4 border-b-blue-800 py-2">Demo English</h2>
            <div className="p-3  mt-4 flex flex-col gap-4">
                <h3 className="text-1xl text-left"> Trace for <span className="font-semibold text-">{label_adaption}</span></h3>
                <Accordion 
                    items={[
                        {
                            title: <span className="text-red-500 font-bold m-auto block">ORIGINAL CONTENT</span>
                        },
                        {
                            title: "1. Custom user",
                            content: (
                                 <Accordion items={[
                                    {
                                        title: 'PAGE 1',
                                        content: (
                                            <>
                                                <p className="mb-2 text-gray-500 dark:text-gray-400">
                                                Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons,
                                                dropdowns, modals, navbars, and more.
                                                </p>
                                                <p className="text-gray-500 dark:text-gray-400">
                                                Check out this guide to learn how to&nbsp;
                                                <a
                                                    href="https://flowbite.com/docs/getting-started/introduction/"
                                                    className="text-cyan-600 hover:underline dark:text-cyan-500"
                                                >
                                                    get started&nbsp;
                                                </a>
                                                and start developing websites even faster with components on top of Tailwind CSS.
                                                </p>
                                            </>
                                        )
                                    },
                                    {
                                        title: 'PAGE 2',
                                        content: (
                                            <>
                                                <p className="mb-2 text-gray-500 dark:text-gray-400">
                                                Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons,
                                                dropdowns, modals, navbars, and more.
                                                </p>
                                                <p className="text-gray-500 dark:text-gray-400">
                                                Check out this guide to learn how to&nbsp;
                                                <a
                                                    href="https://flowbite.com/docs/getting-started/introduction/"
                                                    className="text-cyan-600 hover:underline dark:text-cyan-500"
                                                >
                                                    get started&nbsp;
                                                </a>
                                                and start developing websites even faster with components on top of Tailwind CSS.
                                                </p>
                                            </>
                                        )
                                    }
                                 ]} />
                            )
                        },
                        {
                            title: "2. Dislexia LOW",
                            content: (
                                 <Accordion items={[
                                    {
                                        title: 'PAGE 2',
                                        content: (
                                            <>
                                                <p className="mb-2 text-gray-500 dark:text-gray-400">
                                                Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons,
                                                dropdowns, modals, navbars, and more.
                                                </p>
                                                <p className="text-gray-500 dark:text-gray-400">
                                                Check out this guide to learn how to&nbsp;
                                                <a
                                                    href="https://flowbite.com/docs/getting-started/introduction/"
                                                    className="text-cyan-600 hover:underline dark:text-cyan-500"
                                                >
                                                    get started&nbsp;
                                                </a>
                                                and start developing websites even faster with components on top of Tailwind CSS.
                                                </p>
                                            </>
                                        )
                                    },
                                    {
                                        title: 'PAGE 1',
                                        content: (
                                            <>
                                                <p className="mb-2 text-gray-500 dark:text-gray-400">
                                                Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons,
                                                dropdowns, modals, navbars, and more.
                                                </p>
                                                <p className="text-gray-500 dark:text-gray-400">
                                                Check out this guide to learn how to&nbsp;
                                                <a
                                                    href="https://flowbite.com/docs/getting-started/introduction/"
                                                    className="text-cyan-600 hover:underline dark:text-cyan-500"
                                                >
                                                    get started&nbsp;
                                                </a>
                                                and start developing websites even faster with components on top of Tailwind CSS.
                                                </p>
                                            </>
                                        )
                                    }
                                 ]} />
                            )
                        }
                    ]} 
                />
            </div>
        </div>
    )
}

