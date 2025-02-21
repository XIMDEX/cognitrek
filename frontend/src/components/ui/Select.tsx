
"use client";

import { Label as FBLabel, Select as FBSelect } from "flowbite-react";

export function Select({selectId, options, onChange, className, placeholder = ''}) {
  return (
    <div className={className}>
        {placeholder && (
            <div className="mb-2 block">
                <FBLabel htmlFor={selectId} value={placeholder} />
            </div>
        )}
        <FBSelect id={selectId} onChange={onChange}>
            {options.map(option => (
                <option value={option.value} selected={option.selected ?? false}>{option.label}</option>
            ))}
        </FBSelect>
    </div>
  );
}
