#ifndef UNITATM_TOOLS_H
#define UNITATM_TOOLS_H

int parse_arguments(int argc, char *argv[], int *scale, int *descriptor, int resources[3], unsigned int *seed, double *delay);
int calculate_tokens(int value, int pow10, int resources[3], int tokens[3]);
void display_token_value(int descriptor, int tokens[3], int pow10, double delay);

#endif
