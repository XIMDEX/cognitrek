import { useEffect, useRef, useState } from "react"
import Accordion from "./ui/Accordion"
import { COGNITREK_BACKEND_URL } from "../config/constants"

const ID = '9e175f78-e410-4654-bf94-f1bfff1a7198'
const LABEL = 'Demo variant dyslexia low + user'
const TITLE ="Carta demo"

console.log(COGNITREK_BACKEND_URL)
const mockup = [
    {
        label: 'Dyslexia LOW',
        data: [
            {
                page: 1,
                content: [
                    {
                        "id": 96,
                        "original_text": "Contents",
                        "start_position_modification": 0,
                        "end_position_modification": 7,
                        "modified_text": "**Contents**",
                        "modification": "bolded"
                    },
                    {
                        "id": 102,
                        "original_text": "Senses",
                        "start_position_modification": 0,
                        "end_position_modification": 6,
                        "modified_text": "**Senses**",
                        "modification": "bolded"
                    },
                    {
                        "id": 108,
                        "original_text": " Sensory organs",
                        "start_position_modification": 0,
                        "end_position_modification": 16,
                        "modified_text": "**Sensory organs**",
                        "modification": "bolded"
                    },
                    {
                        "id": 114,
                        "original_text": " The locomotor system",
                        "start_position_modification": 0,
                        "end_position_modification": 19,
                        "modified_text": "**The locomotor system**",
                        "modification": "bolded"
                    },
                    {
                        "id": 117,
                        "original_text": "From the moment you get up until you go to bed, you",
                        "start_position_modification": 0,
                        "end_position_modification": 71,
                        "modified_text": "You are active from the moment you wake up. You go to bed after a long day. ",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 120,
                        "original_text": "perform many di\\ufb00 erent activities. You see the people",
                        "start_position_modification": 0,
                        "end_position_modification": 59,
                        "modified_text": "You do many activities. You see people around you. ",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 123,
                        "original_text": "around you, smell appetising foods that you try, touch",
                        "start_position_modification": 0,
                        "end_position_modification": 63,
                        "modified_text": "You smell appetising foods. You might try some. You touch things around you.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 126,
                        "original_text": "sof , rough, cold or hot objects and react approaching ",
                        "start_position_modification": 0,
                        "end_position_modification": 71,
                        "modified_text": "You feel soft, rough, cold, or hot objects. You react to what you touch.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 129,
                        "original_text": "what you like or causes you pleasure and moving away",
                        "start_position_modification": 0,
                        "end_position_modification": 55,
                        "modified_text": "You move towards things you like. You move away from things that are unpleasant.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 132,
                        "original_text": "from unpleasant or dangerous things.",
                        "start_position_modification": 0,
                        "end_position_modification": 36,
                        "modified_text": "You avoid unpleasant or dangerous things.",
                        "modification": "simplified"
                    },
                    {
                        "id": 135,
                        "original_text": "You are able to recognise stimuli, di\\ufb00 erentiate them ",
                        "start_position_modification": 0,
                        "end_position_modification": 65,
                        "modified_text": "You can recognise different stimuli. You differentiate between them.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 138,
                        "original_text": "and react to them adapting to life conditions of the ",
                        "start_position_modification": 0,
                        "end_position_modification": 69,
                        "modified_text": "You react to these stimuli. You adapt to life conditions.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 141,
                        "original_text": "environment in the best possible way. All this happens",
                        "start_position_modification": 0,
                        "end_position_modification": 61,
                        "modified_text": "You adapt to your environment. All this happens because of your senses.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 144,
                        "original_text": "because of the sensory organs and the coordination ",
                        "start_position_modification": 0,
                        "end_position_modification": 61,
                        "modified_text": "This happens thanks to your **sensory organs** and the coordination system.",
                        "modification": "simplified and bolded"
                    },
                    {
                        "id": 147,
                        "original_text": "system. When you move, you set a powerful and",
                        "start_position_modification": 0,
                        "end_position_modification": 56,
                        "modified_text": "When you move, you activate a powerful system.",
                        "modification": "simplified"
                    },
                    {
                        "id": 150,
                        "original_text": "sophisticated machinery in motion that executes your ",
                        "start_position_modification": 0,
                        "end_position_modification": 68,
                        "modified_text": "This system helps you to execute your movements.",
                        "modification": "simplified"
                    },
                    {
                        "id": 153,
                        "original_text": "orders; you move to another place or make subtle",
                        "start_position_modification": 0,
                        "end_position_modification": 57,
                        "modified_text": "You move to another place. You can also make subtle movements.",
                        "modification": "simplified and split sentence"
                    },
                    {
                        "id": 156,
                        "original_text": "moves with your hands to grab a delicate object.",
                        "start_position_modification": 0,
                        "end_position_modification": 55,
                        "modified_text": "You use your hands to grab delicate objects.",
                        "modification": "simplified"
                    },
                    {
                        "id": 159,
                        "original_text": "Have you ever thought about all this? Something you ",
                        "start_position_modification": 0,
                        "end_position_modification": 54,
                        "modified_text": "Have you ever thought about all this? What you do every day depends on this.",
                        "modification": "simplified"
                    },
                    {
                        "id": 162,
                        "original_text": "do every day implies the functioning of many organs in ",
                        "start_position_modification": 0,
                        "end_position_modification": 62,
                        "modified_text": "It involves the functioning of many organs. They all work together.",
                        "modification": "simplified"
                    },
                    {
                        "id": 165,
                        "original_text": "a coordinated way. Don\\u2019t you think that it is amazing?",
                        "start_position_modification": 0,
                        "end_position_modification": 55,
                        "modified_text": "This is a coordinated way. Isn't that amazing?",
                        "modification": "simplified"
                    }
                ]
            },
            {
                page: 2,
                content: 
                [
                    {
                        "id": 186,
                        "original_text": "Aft er reading the text, talk to your classmate and discuss these questions in pairs: Driving a vehicle involves a great responsibility. Sensory organs play an important role in it: we watch the other drivers, pedestrians and the tra\\ufb03  c signs, we hear acoustic signs, we touch car controls, etc. Taste and smell prepare our digestive system to rehydrate and choose the right type of food to gain strength and continue the journey. The precise moves that help us reach our destination are executed with great ability and con\\ufb01 dence. How do you think the sensory organ of sight works? What should we take care of when driving to make it work properly? What types of sounds can we hear? How should we move when doing a manoeuvre? How should we sit to avoid fatigue dur ing the journey?",
                        "start_position_modification": 0,
                        "end_position_modification": 0,
                        "modified_text": "After reading the text, talk to your classmate. Discuss these questions in pairs. **Driving a vehicle** involves a great responsibility. **Sensory organs** play an important role: 1. We watch the other drivers. 2. We watch pedestrians. 3. We watch the traffic signs. 4. We hear acoustic signs. 5. We touch car controls. **Taste** and **smell** help our digestive system. They prepare us to rehydrate. They help us choose the right type of food. This helps us gain strength. It helps us continue the journey. The precise moves help us reach our destination. They are done with great ability and confidence. **Questions:** 1. How does the sensory organ of sight work? 2. What should we take care of when driving to make it work properly? 3. What types of sounds can we hear? 4. How should we move when doing a manoeuvre? 5. How should we sit to avoid fatigue during the journey?",
                        "modification": "Simplified and broken into shorter sentences; questions listed; key terms bolded."
                    },
                    {
                        "id": 192,
                        "original_text": "\\u2022 Do you know how sensory organs work? \\u2022 Do you know why the body reacts when something damages it? \\u2022 Do you know what a stimulus and a receptor are? \\u2022 Can you identify the parts of the sensory organs? \\u2022 Do you know the systems that make up the locomotor system?",
                        "start_position_modification": 0,
                        "end_position_modification": 0,
                        "modified_text": "**Questions:** 1. Do you know how **sensory organs** work? 2. Do you know why the body reacts when something damages it? 3. Do you know what a **stimulus** and a **receptor** are? 4. Can you identify the parts of the **sensory organs**? 5. Do you know the systems that make up the **locomotor system**?",
                        "modification": "Added bolding to key terms and organized the questions in a numbered list."
                    },
                    {
                        "id": 198,
                        "original_text": "Complete some activities that will guide you through the essential vocabulary of this unit.",
                        "start_position_modification": 0,
                        "end_position_modification": 0,
                        "modified_text": "Complete activities. These activities will guide you through the **essential vocabulary** of this unit.",
                        "modification": "Simplified sentence structure; bolded 'essential vocabulary'."
                    },
                    {
                        "id": 207,
                        "original_text": "Complete the worksheet Find a classmate. Share experiences about these topics with your classmates and discover interesting things about them.",
                        "start_position_modification": 0,
                        "end_position_modification": 0,
                        "modified_text": "1. Complete the **worksheet**. 2. Find a **classmate**. 3. Share experiences about these topics. 4. Discover interesting things about each other.",
                        "modification": "Organized text into a simple numbered list for clarity."
                    }
                ],
            }
        ]
    }
]

export default function TraceLLM({ id=ID, title=TITLE, label=LABEL }) {
    interface Content {
        id: number;
        original_text: string;
        start_position_modification: number;
        end_position_modification: number;
        modified_text: string;
        modification: string;
    }
    
    interface PageData {
        page: number;
        section?: number;
        content: Content[];
    }
    
    interface MockupData {
        label: string;
        data: PageData[];
    }
    
    const [data, setData] = useState<MockupData[]>([])
    const count = useRef(1)
    
    useEffect(() => {
        setData(mockup)
        // fetch(`${COGNITREK_BACKEND_URL}/resources/${id}/variants?label=${encodeURIComponent(label)}`)
        //     .then(response => response.json())
        //     .then(json => setData(json))
        //     .catch(console.error)

    }, [id, label]) 

    return (
        <div className="h-full flex flex-col">
            <h2 className="mx-4 m-auto text-2xl text-center border-b-4 border-b-blue-800 py-2">{title}</h2>
            <div className="p-3 px-8  mt-4 flex flex-col gap-4 flex-1 flex-grow overflow-y-auto">
                <h3 className="text-1xl text-left"> Trace for <span className="font-semibold text-">{label}</span></h3>
                <Accordion 
                    items={[
                        {
                            title: <span className="font-bold text-primary m-auto block">ORIGINAL CONTENT</span>,
                            class: "bg-secondary"
                        },
                        ...data.map(condition => {
                            return {
                                title: `${count.current++}. ${condition.label}`,
                                content: (
                                    <Accordion 
                                        items={condition.data.map((c_data, idx) => {
                                            const page = c_data.page ?? idx
                                            return {
                                                title: c_data.section ?? `PAGE ${page}`,
                                                content: (
                                                    <div className="flex flex-col gap-2 ">
                                                        {c_data.content.map((item, content_idx, arr) => {
                                                            const keywords = item?.modification?.split(/[.,;]\s*/) ?? []
                                                            return (
                                                                <div key={content_idx} className="py-2 flex flex-col gap-2">
                                                                    <h4 className="border-b border-primary text-sm mb-2 pb-1 text-right font-bold text-primary">{`CHANGE ${content_idx} / ${arr.length}`}</h4>
                                                                    <div className="flex flex-row gap-8">
                                                                        <div className="flex flex-col gap  w-1/2  ">
                                                                            <em className="text-sm">Modified:</em>
                                                                            <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-600">
                                                                                <p dangerouslySetInnerHTML={{__html: item.modified_text.replace(/\*\*(.*?)\*\*/g, "<b>$1</b>").replace(/\*(.*?)\*/g, "<i>$1</i>").replace(/__(.*?)__/g, "<u>$1</u>")}}/>
                                                                            </div>
                                                                        </div>
                                                                        <div className="flex flex-col gap w-1/2">
                                                                            <em className="text-sm">Original:</em>
                                                                            <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-600">
                                                                                <p dangerouslySetInnerHTML={{__html: item.original_text.replace(/\*\*(.*?)\*\*/g, "<b>$1</b>").replace(/\*(.*?)\*/g, "<i>$1</i>").replace(/__(.*?)__/g, "<u>$1</u>")}}/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div className="flex flex-row flex-wrap gap-2 justify-start mt-2">
                                                                        {keywords.map((keyword: string, index: number) => {
                                                                            if (!keyword.trim()) return null
                                                                            return ( 
                                                                                <span key={index} className="px-3 py-1 bg-[hsl(var(--primary))]/75 text-white text-sm font-medium rounded-full">
                                                                                    {keyword.trim()}
                                                                                </span> )
                                                                        } )}
                                                                    </div>
                                                                </div>
                                                            )
                                                        })}
                                                    </div>
                                                )
                                            }
                                        })}
                                    />
                                )
                            }
                        })
                    ]} 
                />
            </div>
        </div>
    )
}

