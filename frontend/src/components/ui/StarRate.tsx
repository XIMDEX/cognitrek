"use client"

import React from 'react'
import StarInteractiveIcon from '../icons/StarIcon'

interface StarProps {
  filled: number
  onClick?: () => void
  onMouseEnter?: () => void
  onMouseLeave?: () => void
}

function Star({ filled, onClick, onMouseEnter, onMouseLeave }: StarProps) {
  return (
    <span
      className={`relative inline-block w-6 h-6 ${onClick ? 'cursor-pointer' : 'cursor-default'}`}
      onClick={onClick}
      onMouseEnter={onMouseEnter}
      onMouseLeave={onMouseLeave}
    >
      {filled === 0.5 ? (
        <>
          <div className="absolute w-1/2 h-full overflow-hidden">
            <StarInteractiveIcon
              className="text-[#FFB800] w-[200%] h-full"
              isHalf={true}
              fill="currentColor"
            />
          </div>
          <StarInteractiveIcon
            className="text-[#FFB800] w-full h-full"
            isHalf={false}
            fill="none"
          />
        </>
      ) : (
        <StarInteractiveIcon
          className="text-[#FFB800] w-full h-full"
          isHalf={false}
          fill={filled > 0 ? 'currentColor' : 'none'}
        />
      )}
    </span>
  )
}

interface InteractiveStarsProps {
  rating: number
  onRatingChange: (rating: number) => void
  onFeedbackChange: (feedback: string) => void
  onSubmit: () => void
  feedback: string
}

export function InteractiveStars({
  rating,
  onRatingChange,
  feedback,
  onFeedbackChange,
  onSubmit
}: InteractiveStarsProps) {
  const [hover, setHover] = React.useState(0)

  return (
    <div className="mb-0 border-t border-gray-300 pt-4">
      <div className="flex gap-2 mb-0 ml-[10px]">
        <h3 className="mr-5">Rate the Adaptation</h3>
        <div className="flex gap-1">
          {[1, 2, 3, 4, 5].map((star) => (
            <Star
              key={star}
              filled={hover || getFillValue(rating, star)}
              onClick={() => onRatingChange(star)}
              onMouseEnter={() => setHover(star)}
              onMouseLeave={() => setHover(0)}
            />
          ))}
        </div>
        <span className="text-gray-600 text-sm pt-[2px]">
          Rating: {rating} out of 5
        </span>
      </div>
      <div className="flex gap-2">
        <input
          type="text"
          value={feedback}
          onChange={(e) => onFeedbackChange(e.target.value)}
          placeholder="Your feedback..."
          className="flex-1 py-2 px-3 border border-gray-300 rounded text-sm"
        />
        <button
          onClick={onSubmit}
          className="py-2 px-4 bg-indigo-600 text-white rounded cursor-pointer text-sm"
        >
          Submit
        </button>
      </div>
    </div>
  )
}

interface StaticStarsProps {
    rating: number
    feedbacks: string[]
    className?: string
}

export function StaticStars({ rating, feedbacks, className }: StaticStarsProps) {
  return (
    <div className={className}>
      <div className="flex items-center gap-2 justify-end">
        <div className="flex gap-1 items-end">
            <span className="text-gray-600 text-sm">
            {rating} out of 5
            </span>
            {[1, 2, 3, 4, 5].map((star) => (
                <Star
                  key={star}
                  filled={getFillValue(rating, star)}
                />
            ))}
        </div>
      </div>
      {feedbacks.length > 0 && (
        <div>
          <h4 className="mb-2 text-sm font-bold">
            Customer Feedback:
          </h4>
          <div className="flex flex-col gap-2">
            {feedbacks.map((feedback, index) => (
              <div
                key={index}
                className="p-3 bg-[#f4f4f4] rounded text-sm"
              >
                "{feedback}"
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  )
}

const getFillValue = (rating: number, star: number): number => {
  // Redondea el rating a incrementos de 0.5
  const roundedRating = Math.floor(rating * 2) / 2;
  if (roundedRating >= star) {
    return 1;
  } else if (roundedRating >= star - 0.5) {
    return 0.5;
  } else {
    return 0;
  }
};