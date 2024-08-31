import { Card, CardContent, FormControl, FormControlLabel, Radio, RadioGroup, Typography } from '@mui/material'
import React from 'react'

export default function Question(props) {
    return (
        <Card variant='outlined'>
            <CardContent>
                <Typography
                    fontWeight="bold"
                    component="div"
                    gutterBottom
                    variant='h5'
                    textAlign="center"
                >
                    {props.question.title}
                </Typography>

                <FormControl>
                    <RadioGroup name='answer'>
                        {props.question.answers.map(answer => (
                            <FormControlLabel key={answer.id} control={<Radio />} label={answer.title} value={answer.id} />
                        ))}
                    </RadioGroup>
                </FormControl>
            </CardContent>
        </Card>
    )
}
