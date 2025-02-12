import Accordion from "../components/ui/Accordion"

const mockup = [
    {
        name: 'Custom user',
        pages: [
            [
                {
                    "id": 117,
                    "original_text": "From the moment you get up until you go to bed, you",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "From the moment you **get up** until you **go to bed**. You",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 120,
                    "original_text": "perform many di\ufb00erent activities. You see the people",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "You **perform many activities**. You **see people**",
                    "modification": "simplified and bolded key phrases"
                },
            ],
            [
                {
                    "id": 123,
                    "original_text": "around you, smell appetising foods that you try, touch",
                    "start_position_modification": 0,
                    "end_position_modification": 72,
                    "modified_text": "You **smell appetizing foods**. You **touch**",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 126,
                    "original_text": "sof , rough, cold or hot objects and react approaching ",
                    "start_position_modification": 0,
                    "end_position_modification": 70,
                    "modified_text": "you **feel** soft, rough, cold, or hot objects. You **react** to them.",
                    "modification": "simplified and corrected spelling"
                },
            ]
        ]
    },
    {
        name: 'Dyslexia LOW',
        pages: [
            [
                {
                    "id": 117,
                    "original_text": "From the moment you get up until you go to bed, you",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "From the moment you **get up** until you **go to bed**. You",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 120,
                    "original_text": "perform many di\ufb00erent activities. You see the people",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "You **perform many activities**. You **see people**",
                    "modification": "simplified and bolded key phrases"
                },
            ],
            [
                {
                    "id": 123,
                    "original_text": "around you, smell appetising foods that you try, touch",
                    "start_position_modification": 0,
                    "end_position_modification": 72,
                    "modified_text": "You **smell appetizing foods**. You **touch**",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 126,
                    "original_text": "sof , rough, cold or hot objects and react approaching ",
                    "start_position_modification": 0,
                    "end_position_modification": 70,
                    "modified_text": "you **feel** soft, rough, cold, or hot objects. You **react** to them.",
                    "modification": "simplified and corrected spelling"
                },
            ]
        ]
    },
    {
        name: 'Attention defficit LOW',
        pages: [
            [
                {
                    "id": 117,
                    "original_text": "From the moment you get up until you go to bed, you",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "From the moment you **get up** until you **go to bed**. You",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 120,
                    "original_text": "perform many di\ufb00erent activities. You see the people",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "You **perform many activities**. You **see people**",
                    "modification": "simplified and bolded key phrases"
                },
            ],
            [
                {
                    "id": 123,
                    "original_text": "around you, smell appetising foods that you try, touch",
                    "start_position_modification": 0,
                    "end_position_modification": 72,
                    "modified_text": "You **smell appetizing foods**. You **touch**",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 126,
                    "original_text": "sof , rough, cold or hot objects and react approaching ",
                    "start_position_modification": 0,
                    "end_position_modification": 70,
                    "modified_text": "you **feel** soft, rough, cold, or hot objects. You **react** to them.",
                    "modification": "simplified and corrected spelling"
                },
            ]
        ]
    },
    {
        name: 'Custom user',
        pages: [
            [
                {
                    "id": 117,
                    "original_text": "From the moment you get up until you go to bed, you",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "From the moment you **get up** until you **go to bed**. You",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 120,
                    "original_text": "perform many di\ufb00erent activities. You see the people",
                    "start_position_modification": 0,
                    "end_position_modification": 62,
                    "modified_text": "You **perform many activities**. You **see people**",
                    "modification": "simplified and bolded key phrases"
                },
            ],
            [
                {
                    "id": 123,
                    "original_text": "around you, smell appetising foods that you try, touch",
                    "start_position_modification": 0,
                    "end_position_modification": 72,
                    "modified_text": "You **smell appetizing foods**. You **touch**",
                    "modification": "simplified and bolded key phrases"
                },
                {
                    "id": 126,
                    "original_text": "sof , rough, cold or hot objects and react approaching ",
                    "start_position_modification": 0,
                    "end_position_modification": 70,
                    "modified_text": "you **feel** soft, rough, cold, or hot objects. You **react** to them.",
                    "modification": "simplified and corrected spelling"
                },
            ]
        ]
    }
]

const label_adaption = 'Custom User + Demo Disylexic LOW + Attention deficit LOW + Custom user'


export default function TraceLLM({ id }) {

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

