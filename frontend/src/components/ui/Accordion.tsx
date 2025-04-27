
"use client";

import { Accordion as FBAccordion } from "flowbite-react";

const ItemWithoutContent = ({ children, className = "" }: { children: React.ReactNode, className?: string }) => {

    return (
        <h2 id="FBAccordion-collapse-heading-1">
            <button type="button" className={"flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 gap-3 " + className}>
                {children}
            </button>
        </h2>
    )
}

type AccordionItem = {
    title: React.ReactNode;
    content?: React.ReactNode;
    iscollapsable?: boolean;
    isopen?: boolean;
    class?: string
};


export function Accordion({ items }: { items: AccordionItem[] }) {
    return (
        <FBAccordion className="w-full">
            {items.map((item: AccordionItem, idx: number) => {
                return item.content ?
                    (
                        <FBAccordion.Panel key={idx} isOpen={false} >
                            <FBAccordion.Title className={item.class ?? ''}>{item.title}</FBAccordion.Title>
                            <FBAccordion.Content>
                                {item.content}
                            </FBAccordion.Content>
                        </FBAccordion.Panel>
                    ) : (
                        <FBAccordion.Panel key={idx} isOpen={false}>
                            <ItemWithoutContent className={item.class ?? ''}>{item.title}</ItemWithoutContent>
                        </FBAccordion.Panel>
                    )
            })}
        </FBAccordion>
    );
}

export default Accordion